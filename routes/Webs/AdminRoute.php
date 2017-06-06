<?php
/**
* adminRoute 后台路由配置文件
*
* @author chenlidong
* @since 2017/06/06
*/


//后台的路由
// Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {
// 	Route::get("login", "AuthController@showLoginForm")->name("test.login");
// 	Route::post("login", "AuthController@login");
// 	//后台固定路由
//    	Route::resource('test', 'TestController');
// });

//登录路由
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {
	//登录
	
	Route::post("login", "AuthController@showLoginForm");

	Route::get("index", "BaseController@index");
	Route::get("show", "BaseController@show")->name('sb');
	Route::get("main/index", "MainController@index")->name('main');
	

	//后台固定路由
   	//Route::resource('test', 'TestController');
});


