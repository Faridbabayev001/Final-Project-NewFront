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
Route::get('/index','PagesController@index');
Route::get('/qeydiyyat','PagesController@register');
Route::get('/haqqimizda','PagesController@about');
Route::get('/elaqe','PagesController@contact');
Route::post('/elaqe','PagesController@contact_send');
Route::get('/istekler','PagesController@istek_list');
Route::get('/destekler','PagesController@destek_list');
Route::get('/elan/{slug}','PagesController@single');
  Route::group(['middleware' => 'auth'],function(){
    Route::get('/profilim','PagesController@profil');
    Route::get('/tenzimlemeler','PagesController@profil');
    Route::post('/tenzimlemeler','PagesController@settings');
    Route::get('/desteklerim','PagesController@profil');
    Route::get('/isteklerim','PagesController@profil');
    });
//<=================Page Routes End ================>




//<==================Istek Routes ==================>
Route::get('/istek-elave-et','IstekController@show');
Route::post('/istek-elave-et','IstekController@istek_add');
Route::post('/add_file_change','IstekController@only_pic');
// ajax istek and destek
Route::group(['middleware' => 'auth'],function(){
  Route::get('/istek-edit/{id}','IstekController@istek_edit');
  Route::get('/istek-delete/{id}','IstekController@istek_delete');
  Route::patch('/istek-edit/{id}','IstekController@istek_update');
  Route::post('/deleteAjax','IstekController@deleteAjax');
  });
//<=================Istek Routes End ================>




//<==================Destek Routes ==================>
Route::get('/destek-elave-et','DestekController@show');
Route::post('/destek-elave-et','DestekController@destek_add');
Route::group(['middleware' => 'auth'],function(){
  Route::get('/destek-edit/{id}','DestekController@destek_edit');
  Route::patch('/destek-edit/{id}','DestekController@destek_update');
});
//<=================Destek Routes End ================>



//<==================Google Register Routes ==================>
Route::get('auth/google', 'GoogleController@redirectToProvider')->name('google.login');
Route::get('auth/google/callback', 'GoogleController@handleProviderCallback');
//<==================Google Register Routes ==================>



//<==================Facebook Register Routes ==================>
Route::get('facebook', 'FacebookController@redirectToProvider')->name('facebook.login');
Route::get('facebook/callback', 'FacebookController@handleProviderCallback');
//<==================Facebook Register Routes ==================>



//<==================Nofification Routes ==================>
Route::group(['middleware' => 'auth'],function(){
Route::post('/notification/{id}','PagesController@notification_count');
Route::get('/Bildirişlər','PagesController@profil');
Route::get('/message/{id}','PagesController@message');
Route::get('/Mesajlar/{id}','PagesController@chat');
Route::get('/Bildiriş/{id}','PagesController@notication_single');
Route::get('/accept','PagesController@accept');
Route::get('/refusal/{id}','PagesController@refusal');
Route::get('/accept/{id}','PagesController@accept');
Route::get('/chat/{id}/{elan_id}','PagesController@chatToNoti');
});
//<=================Nofification Routes End ================>



//<=================Auth and User Routes ===========>
Route::auth();
Route::get('/home', 'PagesController@index');
Route::post('/user-login','PagesController@user_login');
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');
//<=================Auth and User Routes End ===========>



//<=================Admin Routes ===========>
Route::get('/alfagen/login', 'AdminController@login');
Route::post('/alfagen/postLogin', 'AdminController@postLogin');


  Route::group(['middleware' => ['auth', 'admin']],function(){
    Route::get('/alfagen','AdminController@index');
    Route::get('/alfagen/logout', 'AdminController@logout');
    Route::get('/İstək-list','AdminController@istek_list');
    Route::get('/admin/elan-edit/{elan}','AdminController@elan_edit');
    Route::post('/admin/elan-edit/{elan}','AdminController@elan_edit_update');
    Route::get('/Dəstək-list','AdminController@destek_list');
    Route::get('/activate/{id}','AdminController@activate');
    Route::get('/deactivate/{id}','AdminController@deactivate');
    Route::get('admin/qarsiliqlar','AdminController@qarsiliq');
});
//<=================Admin Routes ===========>
