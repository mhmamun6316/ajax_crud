<?php

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

Route::get('/crud','ProductController@index');
Route::get('/product/all/','ProductController@getall');
Route::post('/product/store/','ProductController@store_product');
Route::get('/product/edit/{id}','ProductController@edit_product');
Route::post('/product/update/{id}','ProductController@update_product');
Route::get('/product/delete/{id}','ProductController@delete_product');