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
    public function userList()
    {   
        $userList = array();
        $users = $this->getAdminService()->getUserList();
        if($users){
            foreach ($users as $key => $user) {
                $role = array();
                $userList[$key]['id'] = $user['id'];
                $userList[$key]['name'] = $user['name'];
                $roleId = $this->getAdminService()->getRoleByUid($user['id']);
                if ($roleId) $role = $this->getAdminService()->getRoleById($roleId['0']['role_id']);
                $userList[$key]['role_name'] = $role ? $role[0]['display_name'] : '';
                $userList[$key]['created_at'] = $user['created_at'];
            }
        }
        var_dump($userList);exit();
    }

    /**
     * 添加或者修改后台登陆用户
     *
     * @param  array  $data
     * @return User
     */
    public function addEditUser(Request $request)
    {   
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $roleId = $request->input('role');
        $status = $request->input('status');
        //读取用户信息
        $data = array();
        $userInfo = array();
        if ($id) {
            $role = $this->getAdminService()->getRoleByUid($id);
            if ($role) $data['roleId'] = $role[0]['role_id'];
            $userInfo = $this->getAdminService()->getUserInfoById($id);
            if ($userInfo) {
                $data['name'] = $userInfo[0]['name'];
                $data['email'] = $userInfo[0]['email'];
                $data['status'] = $userInfo[0]['status'];
                $data['id'] = $id;
            }
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users,name',
                'email' => 'required',
                'role' => 'required|numeric',
                'status' => 'present',
                'id' => 'present'
            ]);
            if ($validator->fails()) {
                return redirect('admin/addedituser')
                            ->withErrors($validator)
                            ->withInput();
            }
            if ($userInfo) {
                //编辑
                $insertFields = array();
                if ($name != $userInfo[0]['name']) $insertFields['name'] = $name;
                if ($email != $userInfo[0]['email']) $insertFields['email'] = $email;
                if ($status != $userInfo[0]['status']) $insertFields['status'] = $status;
                if($this->getAdminService()->updateUserInfo($id, $insertFields)){
                    if ($roleId && $roleId != $data['roleId']) {
                        if($this->getAdminService()->updateUserRole($id, $roleId)){
                            echo '编辑成功';exit();
                        }
                    }
                }
            } else {
                //添加
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('123456'),
                ]);
                if($user && $roleId) {
                    if($this->getAdminService()->insertUserRole($user->id, $roleId)){
                        echo '添加成功';exit();
                    }
                }
            }
        }

        //取出所有的用户组
        $role = $this->getAdminService()->getRoleList();
        if ($role) {
            $roleList = array();
            foreach ($role as $key => $item) {
                $roleList[$key]['id'] = $item['id'];
                $roleList[$key]['display_name'] = $item['display_name'];
            }
            $data['role'] = $roleList;
        }
        //var_dump($data);exit();
        return view('admin.login.edituser', $data);
        //var_dump($this->getAdminService()->getUserList());exit();
    }

    /**
     * 用户组列表
     *
     * @param  array  $data
     * @return User
     */
    public function roleList()
    {   
        var_dump($this->getAdminService()->getUserList());exit();
    }

    /**
     * 添加用户组或者修改用户组的权限设置
     *
     * @param  array  $data
     * @return User
     */
    public function editRole(Request $request)
    {   
        
    }


    //测试
    public function test()
    {   
        $id = 6;
        $data = array();
        $data['name'] = 'zzeqweq';
        $data['eamil'] = 'dgasd@sadkkk.com';
        $data['id'] = $id;
        return view('admin.login.edituser',['data'=> $data, 'id' => $id ]);
    }

    /**
     * 修改密码
     *
     * @param  array  $data
     * @return User
     */
    public function resetsPassword(Request $request)
    {   
        if ($request->isMethod('post')) {
            $id = $this->bkAdminUser['id'];
            if ($id) {
                $oldPassword = $request->input('old_password');
                $newPassword = $request->input('new_password');
                $new_repeat_password = $request->input('new_repeat_password');
                //数据格式验证
                $validator = Validator::make($request->all(), [
                    'old_password' => 'required',
                    'new_password' => 'required|min:6',
                    'new_repeat_password' => 'required|min:6'
                ]);
                if ($validator->fails()) return redirect($this->bkAdminUri)->withInput()->withErrors($validator);
                //新旧密码一样
                if ($oldPassword == $newPassword) {
                    $errors = ['new_password' => trans('passwords.password_repeat')];
                    return redirect()->back()->withInput()->withErrors($errors);
                }
                //确定密码不一致
                if ($newPassword != $new_repeat_password) {
                    $errors = ['new_password' => trans('passwords.new_password_repeat')];
                    return redirect()->back()->withInput()->withErrors($errors);
                }
                //原密码是否正确
                $user = $this->getAdminService()->getUserInfoById($id);
                if(!password_verify($oldPassword, $user[0]['password'])) {
                    $errors = ['old_password' => trans('auth.failed')];
                    return redirect()->back()->withInput()->withErrors($errors);
                }
                //更改密码
                if ($this->getAdminService()->updateUserInfo($id, array('password' => bcrypt($newPassword)))) return redirect('/admin/main/index');
            }
        }
        return view('admin.login.resetpassword');
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
