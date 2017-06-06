<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{   
    /**
     * 展示给定用户的信息。
     *
     * @param  int  $id
     * @return Response
     */
    public function login(Request $request){
        //$user = Auth::user();
        //var_dump($request->user()->password);exit();
        //var_dump($request->input('name', 'sss'));
    	//$cookie = cookie('name', 'value', 10); 
    	//Cookie::queue('sb', 22222, 10);
    	//var_dump(Cookie::get('sb'));
		//return view('admin.login.login', ['name' => 'James']);//
		return view('admin.login.login');
    }

    /*
     * 表单验证
     *
     * @param  int  $id
     * @return Response
     */
    public function sign(Request $request){
        $users = DB::select('select * from users where 1 = ?', [1]);
        foreach ($users as $key => $value) {
            var_dump($key);
        }
        
        // $this->validate($request, [
        //     'username' => 'bail|required|unique:posts|max:255',
        //     'password' => 'required',
        // ]);
        // var_dump($request->username);exit();
        //return view('admin.login.login');
    }


}
