<?php

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
	// echo __DIR__;
    return redirect()->route('admin_main');
});

//后台路由
require_once '/laravel/test/routes/Webs/AdminRoute.php';


// //前台的路由
// Route::group(['prefix' => 'home', 'middleware' => 'HomeInfo'], function () {
//     Route::get('login/{id}', function ($id)    {

//     });
//     require_once __DIR__.'/../defineroute/homeroute.php';
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
