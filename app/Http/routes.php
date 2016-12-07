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
Route::post('/Əlaqə','PagesController@contact_send');
Route::get('/Tənzimləmələr','PagesController@profil');
Route::post('/Tənzimləmələr','PagesController@settings');
Route::get('/Profil','PagesController@profil');
Route::get('/Istekler','PagesController@profil');
Route::get('/istek-list','PagesController@istek_list');
Route::get('/Destekler','PagesController@profil');
Route::get('/destek-list','PagesController@destek_list');
Route::get('/Tənzimləmələr','PagesController@profil');
Route::get('/single/{id}','PagesController@single');
//<=================Page Routes End ================>



//<==================Istek Routes ==================>
Route::get('/istek-add','IstekController@show');
Route::post('/istek-add','IstekController@istek_add');
Route::get('/istek-edit/{id}','IstekController@istek_edit');
Route::get('/istek-delete/{id}','IstekController@istek_delete');
Route::patch('/istek-edit/{id}','IstekController@istek_update');
Route::post('/add_file_change','IstekController@only_pic');
Route::post('/pic_delete','IstekController@pic_delete');
//<=================Istek Routes End ================>



//<==================Destek Routes ==================>
Route::get('/destek-add','DestekController@show');
Route::post('/destek-add','DestekController@destek_add');
Route::get('/destek-edit/{id}','DestekController@destek_edit');
Route::patch('/destek-edit/{id}','DestekController@destek_update');
//<=================Destek Routes End ================>


//<==================Nofification Routes ==================>
Route::post('/notification/{id}','PagesController@notification_count');
Route::get('/Bildirişlər','PagesController@profil');
Route::get('/message/{id}','PagesController@message');
Route::get('/Bildiriş/{id}','PagesController@notication_single');
Route::get('/accept','PagesController@accept');
Route::get('/refusal/{id}','PagesController@refusal');
Route::get('/accept/{id}','PagesController@accept');
//<=================Nofification Routes End ================>


//<=================Auth and User Routes ===========>
Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');
//<=================Auth and User Routes End ===========>

//<=================Admin Routes ===========>
Route::group(['middleware' => 'admin'],function(){
Route::get('/alfagen','AdminController@index');
Route::get('/alfagen/login', 'AdminController@login');
Route::post('/alfagen/postLogin', 'AdminController@postLogin');
Route::get('/alfagen/logout', 'AdminController@logout');
Route::get('/İstək-list','AdminController@istek_list');
Route::get('/Dəstək-list','AdminController@destek_list');
Route::get('/activate/{id}','AdminController@activate');
Route::get('/deactivate/{id}','AdminController@deactivate');
});
//<=================Admin Routes ===========>
