<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/attribute', "AttributeController@index")->name('attribute.index');
Route::post('/attribute', "AttributeController@store")->name('attribute.store');

Route::get('/variant', "AttributeValueController@index")->name('variant.index');
Route::post('/variant', "AttributeValueController@store")->name('variant.store');

Route::get('/product', "ProductController@index")->name('product.index');
Route::post('/product', "ProductController@store")->name('product.store');
Route::get('/product/{id}', "ProductController@edit")->name('product.edit');
Route::post('/product/{id}', "ProductController@update")->name('product.update');
Route::get('/', "ProductController@all")->name('product.all');
Route::get('/details/{id}', "ProductController@details")->name('product.details');
