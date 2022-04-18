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

Route::resource('items', '\App\Http\Controllers\ItemController');
Route::resource('categories', '\App\Http\Controllers\CategoryController');
Route::resource('/', '\App\Http\Controllers\ListController');
Route::resource('home', '\App\Http\Controllers\HomeController');
Route::resource('products', '\App\Http\Controllers\ListController');
Route::resource('cart', '\App\Http\Controllers\CartController');
Route::resource('order', '\App\Http\Controllers\OrderController');
Route::resource('thankyou', '\App\Http\Controllers\ThankyouController');


// Route::get('/', function () {
//     return view('products.index');
// });

Auth::routes();
