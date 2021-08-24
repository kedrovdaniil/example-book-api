<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthorBook extends Pivot
{
    use HasFactory;

    protected $table = 'author_book';

    protected $fillable = [
        'author_id',
        'book_id'
    ];
}
