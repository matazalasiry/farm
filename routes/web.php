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
//
//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/','ClientController@home');
Route::get('/shop','ClientController@shop');
Route::get('/cart','ClientController@cart');
Route::get('/checkout','ClientController@checkout');
Route::get('/client_login','ClientController@login');
Route::get('/client_logout','ClientController@logout');
Route::get('/signup','ClientController@signup');
Route::get('/addToCart/{id}','ClientController@addToCart');
Route::Post('updateqty','ClientController@updateqty');
Route::get('removeitem/{id}','ClientController@removeitem');
Route::post('postcheckout','ClientController@postcheckout');
Route::post('createaccount','ClientController@createaccount');
Route::post('accessaccount','ClientController@accessaccount');
Route::get('/view_by_cat/{name}','ClientController@view_by_cat');


Route::get('/dashboard','AdminController@dashboard');
Route::get('/orders','AdminController@orders');

Route::get('/addcategory','CategoryController@addcategory');
Route::post('/savecategory','CategoryController@savecategory');
Route::get('/categories','CategoryController@categories');
Route::get('/edit_category/{id}','CategoryController@edit');
Route::post('/updatecategory','CategoryController@updatecategory');
Route::get('/delete/{id}','CategoryController@delete');


Route::get('/addproduct','ProductController@addproduct');
Route::get('/products','ProductController@products');
Route::post('/saveproduct','ProductController@saveproduct');
Route::get('/edit_product/{id}','ProductController@editproduct');
Route::post('/updateproduct','ProductController@updateproduct');
Route::get('/delete_product/{id}','ProductController@delete_product');
Route::get('/active_product/{id}','ProductController@active');
Route::get('/unactive_product/{id}','ProductController@unactive');


Route::get('/sliders','SliderController@sliders');
Route::get('/addslider','SliderController@addslider');
Route::post('/saveslider','SliderController@saveslider');
Route::get('/edit_slider/{id}','SliderController@editslider');
Route::post('/updateslider','SliderController@updateslider');
Route::get('/delete_slider/{id}','SliderController@delete_slider');
Route::get('/active_slider/{id}','SliderController@active');
Route::get('/unactive_slider/{id}','SliderController@unactive');


Route::get('/view_pdf/{id}','PdfController@view_pdf');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
