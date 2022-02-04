<?php

use App\Http\Controllers\Dashboard\Ajax\AuthorBookDetachController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\Dashboard\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('authors')->group(function (){
    Route::get('', [AuthorController::class, 'index'])->name('authors.index');
    Route::post('', [\App\Http\Controllers\Dashboard\Ajax\AuthorController::class, 'store'])->name('author.create');
    Route::get('search', [\App\Http\Controllers\Dashboard\Ajax\AuthorController::class, 'index'])->name('author.search');
    Route::prefix('{authorId}')->group(function (){
        Route::get('', [AuthorController::class, 'show'])->name('author.show');
        Route::get('edit', [AuthorController::class, 'edit'])->name('author.edit');
        Route::patch('', [AuthorController::class, 'update'])->name('author.update');
        Route::delete('', [\App\Http\Controllers\Dashboard\Ajax\AuthorController::class, 'destroy'])->name('author.destroy');
    });
});

Route::prefix('books')->group(function (){
    Route::get('', [BookController::class, 'index'])->name('books.index');
    Route::post('', [\App\Http\Controllers\Dashboard\Ajax\BookController::class, 'store'])->name('book.create');
    Route::prefix('{bookId}')->group(function (){
        Route::get('', [BookController::class, 'show'])->name('book.show');
        Route::get('edit', [BookController::class, 'edit'])->name('book.edit');
        Route::patch('', [BookController::class, 'update'])->name('book.update');
        Route::delete('', [\App\Http\Controllers\Dashboard\Ajax\BookController::class, 'destroy'])->name('book.destroy');

        /* Detach author ID of book */
        Route::get('author/{authorId}', [AuthorBookDetachController::class, 'destroy'])
               ->middleware('check_book_author')
               ->name('book.author.detach');
    });
});
