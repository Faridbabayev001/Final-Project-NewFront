<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//<==================Page Routes ==================>
Route::get('/','PagesController@index');
Route::get('/Qeydiyyat','PagesController@register');
Route::get('/Haqqımızda','PagesController@about');
Route::get('/Əlaqə','PagesController@contact');
Route::get('/Profil','PagesController@profil');
Route::get('/Istekler','PagesController@profil');
Route::get('/Destekler','PagesController@profil');
Route::get('/single/{id}','PagesController@single');
//<=================Page Routes End ================>



//<==================Istek Routes ==================>
Route::get('/istek-add','IstekController@show');
Route::post('/istek-add','IstekController@istek_add');
//<=================Istek Routes End ================>



//<==================Destek Routes ==================>
Route::get('/destek-add','DestekController@show');
Route::post('/destek-add','DestekController@destek_add');
//<=================Destek Routes End ================>



//<=================Auth and User Routes ===========>
Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');
//<=================Auth and User Routes End ===========>

//<=================Admin Routes ===========>

//<=================Admin Routes ===========>
