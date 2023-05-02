<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;

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

Route::get('/dashboard', function () {
    return view('backend.artikel');
});

Route::get('/create/artikel', function () {
    return view('backend.tambah-artikel');
});

Route::get('/v1/article', [ArticleController::class, 'getAllData'])->name('getData.artikel');
Route::post('/v1/article', [ArticleController::class, 'createData'])->name('tambahData.artikel');
Route::post('/v1/article/{id}', [ArticleController::class, 'updateData']);

