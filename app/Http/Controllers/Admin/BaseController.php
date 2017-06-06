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

class BaseController extends Controller
{   
    public $bkAdminUser = array();

    //初始化信息，验证登陆信息
    public function __construct()
    {   //echo 22;exit();
        $this->middleware('auth');
        // var_dump(Auth::user());exit()
        // //验证用户是否登录
        // if(Auth::check()){
        //     $this->bkAdminUser = Auth::user();
        // } else {
        //     redirect()->route('login');
        // }
    }

    public function index()
    {
        return redirect()->route('sb');
    }

    public function show()
    {
        echo 'show';
    }
}
