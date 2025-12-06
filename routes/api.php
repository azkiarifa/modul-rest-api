<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

Route::get('books', [BookController::class, 'index']);
Route::get('books/search', [BookController::class, 'search']);
Route::get('books/filter/year', [BookController::class, 'filterByYear']);
Route::get('books/filter', [BookController::class, 'filterByPublisherAndAuthor']);

Route::get('/books/range', [BookController::class, 'range']);
Route::get('/books/sort/year', [BookController::class, 'sortByYear']); // opsional
Route::get('/books/search', [BookController::class, 'search']); // opsional
Route::get('/books/filter', [BookController::class, 'filterByPublisherAndAuthor']);

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});
