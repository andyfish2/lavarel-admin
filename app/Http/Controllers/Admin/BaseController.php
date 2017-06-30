<?php
/**
* BaseController
*
* @author chenlidong
* @since 2017/06/06
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\ServiceFactory;

class BaseController extends Controller
{      
    //后台登录账户信息
    public $bkAdminUser = array();

    //当前路由信息
    public $bkAdminUri = '';

    //主页面路由
    public $adminHomeUri = 'admin/main/index';

    //是否是系统内置管理员
    public $isSystemAdmin = 0;
    
    //渠道列表，应用列表
    public $roleAppSource = array();

    //获取AdminService
    public function getAdminService() {
        return ServiceFactory::getInstance()->createAdminService();
    }

    //获取BusinessService
    public function getBusinessService() {
        return ServiceFactory::getInstance()->createBusinessService();
    }

    //初始化信息
    public function __construct()
    {   
        //获取当面用户的信息
        $this->middleware(function ($request, $next) {
            $this->bkAdminUser['id'] = Auth::user()['attributes']['id'];
            $this->bkAdminUser['name'] = Auth::user()['attributes']['name'];
            $this->bkAdminUser['email'] = Auth::user()['attributes']['email'];
            $this->bkAdminUser['appSource'] = $this->getAdminService()->getUserAppSource(Auth::user()['attributes']['id']);
            return $next($request);
        });
        //获取当前的路由
        $this->bkAdminUri = Route::getCurrentRoute()->uri;
        //判断当前权限
        if(!empty($this->bkAdminUri) && $this->bkAdminUri != $this->adminHomeUri )
        {
            //$this->middleware('permission:'.$pes)->except('show');
            $this->middleware('permission:'.$this->bkAdminUri);
        }
    }

    /**
     * 获取当前的年,月,日
     * @return array
     */
    public function getYearMonthHour(){
        return array('year' => date('Y',time()), 'month' => date('m',time()), 'day' => date('d',time()));

    }
    // private function _transPes($route_name)
    // {
    //     $a = explode(".", $route_name);
    //     if($a[count($a)-1] == 'index' or $a[count($a)-1] == 'show')
    //     {
    //         $a[count($a)-1] = 'view';
    //     }

    //     return join('.', $a);
    // }

    // public function index()
    // {   
    //     var_dump('ok');
    //     //$value = $request->session();
    //     var_dump($this->bkAdminUser);exit();
    //     //return redirect()->route('sb');
    // }

    // public function show()
    // {
    //     var_dump('no');exit();
    // }
}
