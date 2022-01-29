<?php

use App\Http\Controllers\Dashboard\AuthorController;
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

    Route::get('', [AuthorController::class, 'index']);
    Route::post('', [\App\Http\Controllers\Dashboard\Ajax\AuthorController::class, 'store']);
    Route::prefix('{authorId}')->group(function (){
        Route::patch('', [\App\Http\Controllers\Dashboard\Ajax\AuthorController::class, 'update']);
        Route::delete('', [AuthorController::class, 'index']);
    });

});
