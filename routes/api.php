<?php

use App\Http\Controllers\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within artisan group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Books routes
 */
// get books (with filters & sort)
Route::get("/books", [BooksController::class, 'index']);
// create artisan book
Route::post("/books/create", [BooksController::class, 'store']);
// update artisan book
Route::put("/books/{id}/update", [BooksController::class, 'update']);
