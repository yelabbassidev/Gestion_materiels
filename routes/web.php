<?php

use Illuminate\Support\Facades\Auth;
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
    return view('index');
})->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Auth::routes();


Route::resource('article', 'ArticlesController')->middleware('auth');
Route::resource('gestionentrees', 'GestionEntreesController')->middleware('auth');
Route::resource('gestionsorties', 'GestionSortiesController')->middleware('auth');


Route::get('/getArticles', 'ArticlesController@getArticles')->name('getArticles')->middleware('auth');
Route::get('/getEntrees/{id}', 'GestionEntreesController@getEntrees')->name('getEntrees')->middleware('auth');
Route::get('/getSorties/{id}', 'GestionSortiesController@getSorties')->name('getSorties')->middleware('auth');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
