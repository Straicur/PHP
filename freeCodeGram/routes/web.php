<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/',[PagesController::class , 'index']);
Route::get('/about',[PagesController::class , 'about']);
//Route::get('/products',[ProductController::class , 'index'])->name('products');
// Route::get('/products/{id}',[ProductController::class , 'show'])->where('id','[0-9]+');//Tylko int
// Route::get('/products/{id}/{name}',[ProductController::class , 'show'])->where([
//     'id'=>'[0-9]+',
//     'name'=>'[a-z]+'
// ]); //Tylko string
