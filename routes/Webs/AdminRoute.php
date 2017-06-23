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

//后台
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
	//后台主面板
	Route::get("main/index", "MainController@index")->name('admin_main');

	//权限设置
	Route::get("userlist", "AdminController@userList")->name('admin_userlist');//用户列表
	Route::match(['post','get'], "resetspassword", "AdminController@resetsPassword")->name('admin_resetspassword');//修改密码
	Route::match(['post','get'], "addedituser", "AdminController@addEditUser")->name('admin_edituser');//修改或者添加用户信息

	Route::get("test", "AdminController@test")->name('admin_test');
	//市场
	Route::get("business/inside", "BusinessController@inside")->name('admin_business_inside');
	Route::get("business/outside", "BusinessController@outside")->name('admin_business_outside');
	Route::get("business/cpa", "BusinessController@cpa")->name('admin_business_cpa');
	Route::get("business/cps", "BusinessController@cps")->name('admin_business_cps');

	//Route::get("show", "BaseController@show")->name('sb');
	//后台固定路由
   	//Route::resource('test', 'TestController');
});

//api
// Route::get('/user',function(Request $request){
// 	return 'apiaa';
// })->middleware('auth:api');

