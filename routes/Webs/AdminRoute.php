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

Route::group(['prefix' => 'admin', 'namespace'=>'Admin', 'middleware'=>'auth'], function () {
	//后台主面板
	Route::get("main/index", "MainController@index")->name('admin_main');
	
	//财务
	Route::get("finance", "FinanceController@index")->name('admin_finance');

	//市场
	Route::get("business", "BusinessController@index")->name('admin_business');
	
	//运营
	Route::get("operate", "OperateController@index")->name('admin_operate');

	//
	//Route::get("show", "BaseController@show")->name('sb');
	//后台固定路由
   	//Route::resource('test', 'TestController');
});


