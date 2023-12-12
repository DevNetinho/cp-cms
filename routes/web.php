<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\HomeController;



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
    return view('home');
});

Auth::routes();

//ROTAS ADMIN QUE EXIGEM AUTENTICAÇÃO
Route::prefix('/admin')->middleware('auth')->group(function() {
    Route::get('/', function() {
        return view('home_admin');
    })->name('novo-post');

    Route::get('/editar-post', function() {
        return view('editar_post');
    })->name('editar-post');

    Route::get('/config-user', function() {
        return view('config.config-user');
    })->name('config-user');

    Route::get('/config-password', function() {
        return view('config.config-password');
    })->name('config-password');
});



Route::get('/posts', function() { //ROTA DOS POSTS
    return view('posts');
})->name('posts');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();
