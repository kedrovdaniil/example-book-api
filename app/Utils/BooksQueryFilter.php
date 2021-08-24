<?php

namespace App\Utils;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BooksQueryFilter {

    protected $builder;
    protected $request;
    protected $orderByAllowedFields;

    /**
     * BooksQueryFilter constructor.
     * @param $builder
     * @param $request
     * @param array $orderByAllowedFields
     */
    function __construct($builder, $request, array $orderByAllowedFields)
    {
        $this->builder = $builder;
        $this->request = $request;
        $this->orderByAllowedFields = $orderByAllowedFields;
    }

    /**
     * Apply filters to the builder
     * @return mixed
     */
    public function apply()
    {
        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter) && !is_null($value)) {
                $this->$filter(strval($value));
            }
        }

        return $this->builder;
    }

    /**
     * Get all query params from artisan request
     * @return mixed
     */
    private function filters()
    {
        return $this->request->all();
    }

    private function orderBy($value)
    {
        // check if artisan value for "order by" expression is contains in model's fillable fields
        if (!in_array($value, $this->orderByAllowedFields)) return;

        $this->builder->orderBy($value);
    }

    private function orderByDesc($value)
    {
        // check if artisan value for "order by" expression is contains in model's fillable fields
        if (!in_array($value, $this->orderByAllowedFields)) return;

        $this->builder->orderByDesc($value);
    }

    private function offset($value)
    {
        return $this->builder->offset($value);
    }

    private function limit($value)
    {
        return $this->builder->take($value);
    }

    private function authorId($value)
    {
        return $this->builder->join('author_book', 'books.id', '=', 'author_book.book_id')->where('author_id', $value);
    }

    private function title($value)
    {
        return $this->builder->where('title', $value);
    }

    private function titleSearch($value)
    {
        $value = trim(strtolower($value));

        return $this->builder->whereRaw('LOWER("title") LIKE ?', trim(strtolower($value))."%");
    }

    private function description($value)
    {
        return $this->builder->where('description', $value);
    }

    private function descriptionSearch($value)
    {
        $value = trim(strtolower($value));

        return $this->builder->whereRaw('LOWER("description") LIKE ?', trim(strtolower($value))."%");
    }

    private function createdAt($value)
    {
        return $this->builder->where('created_at', $value);
    }

    private function page($page)
    {
        foreach ($this->filters() as $filter => $value) {
            if ($filter === "perPage") {
                return $this->builder->forPage($page, $value);
            }
        }

        return $this->builder;
    }
}
