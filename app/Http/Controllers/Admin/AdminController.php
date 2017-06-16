<?php
/**
* AdminController
* @desc 用户信息，用户组配置
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\Permission;
// use App\Models\Role;
use App\Models\User;

class AdminController extends BaseController
{
    /**
     * 后台登陆用户列表
     *
     * @param  array  $data
     * @return User
     */
    public function userList(Request $request)
    {   
        var_dump($this->bkAdminUser);exit;

    	//var_dump($request->all());
    	//$a = $request->input('a');
    	//return response($a);
    	//var_dump($a);exit(); 
    	//return response('Hello World', 200);exit();
    	//$param = $this->
    	//var_dump($request);exit();
    	// $this->validate($request, [
     //    	'title' => 'required|unique:posts|max:255',
     //    	'body' => 'required',
	    // ]);

        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);


    	// $data['name'] = 'admin7';
    	// $data['email'] = '6qq.com';
    	// $data['password'] = 123456;
    	// //var_dump(bcrypt(123456));exit();
     //    //var_dump($data);exit();
     //    exit;
     //    return User::create([
     //        'name' => $data['name'],
     //        'email' => $data['email'],
     //        'password' => bcrypt($data['password']),
     //    ]);
    }

    /**
     * 添加用户组的渠道，应用
     *
     * @param  array  $data
     * @return User
     */
    public function addRoleAppSource(Request $request)
    {   


        //var_dump($request->all());
        //$a = $request->input('a');
        //return response($a);
        //var_dump($a);exit(); 
        //return response('Hello World', 200);exit();
        //$param = $this->
        //var_dump($request);exit();
        // $this->validate($request, [
     //     'title' => 'required|unique:posts|max:255',
     //     'body' => 'required',
        // ]);

        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);


        // $data['name'] = 'admin7';
        // $data['email'] = '6qq.com';
        // $data['password'] = 123456;
        // //var_dump(bcrypt(123456));exit();
     //    //var_dump($data);exit();
     //    exit;
     //    return User::create([
     //        'name' => $data['name'],
     //        'email' => $data['email'],
     //        'password' => bcrypt($data['password']),
     //    ]);
    }

}
