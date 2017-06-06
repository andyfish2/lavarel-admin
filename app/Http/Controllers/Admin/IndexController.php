<?php
/**
* BaseController
* @desc 后台主面板配置信息，左边菜单列表，配置信息设置
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends BaseController
{	

	/**
     * 主面板配置信息
     */
    public function index(){
    	echo 'main.index';
    }
}
