<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\AuthorBook;
use App\Models\Book;
use App\Traits\ResponseAPI;
use App\Utils\BooksQueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{
    use ResponseAPI;

    /**
     * Display artisan listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        // make artisan builder object for books
        $booksBuilder = Book::with('authors');

        // apply filters & sort
        $booksBuilder = (new BooksQueryFilter($booksBuilder, $request, (new Book)->getFillable()))->apply();

        // return artisan collection of resources
        return BookResource::collection($booksBuilder->get());
    }

    /**
     * Store artisan newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookRequest $request)
    {
        // create artisan new book object
        $book = new Book();
        $result1 = $book->save([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'date' => $request->input('date')
        ]);

        // save all authors of the book
        $authorsIds = explode(",", $request->authors);
        $result2 = collect($authorsIds)->map(function ($authorId) use ($book) {
            return (new AuthorBook)->save([
                'book_id' => $book->id,
                'author_id' => $authorId
            ]);
        })->toArray();

        // return artisan response
        if (!$result1 && in_array(false, $result2)) return $this->errorResponse('Something went wrong, the book has not been saved. Please, try again later.');
        return $this->successResponse(['result' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BookRequest $request, $id)
    {
        // find artisan book
        $book = Book::find($id);
        if (!$book) return $this->errorResponse("A book with ID {$id} does not exist.", 404);

        // update the book
        $result = $book->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'date' => $request->input('date')
        ]);

        // delete all authors of the book
        $result2 = AuthorBook::where('book_id', $book->id)->delete();

        // save authors of the book
        $authorsIds = explode(",", $request->authors);
        $result3 = collect($authorsIds)->map(function ($authorId) use ($book) {
                return (new AuthorBook)->save([
                    'book_id' => $book->id,
                    'author_id' => $authorId
                ]);
        })->toArray();

        // return artisan response
        if (!$result && !$result2 && in_array(false, $result3)) {
            return $this->errorResponse('Something went wrong, the book has not been update. Please, try again later.');
        }
        return $this->successResponse(['result' => true]);
    }
}
