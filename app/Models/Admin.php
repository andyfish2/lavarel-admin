<?php
/**
* Admin
* @desc 权限点，菜单
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Admin extends BaseConstant
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uri_alias'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @desc 左侧菜单(权限点)
     * @return array
     */
    public function getLeftMenu () {
        $leftMenus = array();
        $menus = $this->getAdminMenus();
        if ($menus) {
          foreach ($menus as $menu) {
            $menu = (array)$menu;
            if ($menu['parent_id'] == 0) $leftMenus[$menu['id']] = $menu;
          }
          foreach ($menus as $menu) {
            $menu = (array)$menu;
            if ($menu['parent_id']) $leftMenus[$menu['parent_id']]['sub'][] = $menu;
          }
        }
        return $leftMenus;
    }

    /**
     * @desc 获取全部菜单(权限点)
     * @return array
     */
    private function getAdminMenus(){
        $menus = array();
        $menus = DB::select("SELECT * FROM permissions ORDER BY order_id ASC");
        return $menus;
    }

    /**
     * @desc 获取用户的权限id
     * @return array
     */
    public function getPermissionIds ($uid) {
        $permission = array();
        $permissionIds = array();
        if ($uid) {
            $roleId = $this->getRoleByUid($uid);
            if ($roleId) $permissionIds = DB::select('SELECT permission_id FROM permission_role WHERE role_id = :role_id',  ['role_id' => $roleId[0]['role_id']]);
            if ($permissionIds) {
                foreach ($permissionIds as $key => $id) {
                    $id = (array) $id;
                    $permission[] = $id['permission_id'];
                }
            }
        }
        return $permission;
    }

    /**
     * @desc 获取用户的用户组
     * @return array
     */
    public function getRoleByUid ($uid) {
        $result = array();
        if ($uid) {
            $result = DB::select('SELECT role_id FROM role_user WHERE user_id = :user_id limit 1',  ['user_id' => $uid]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 根据id获取用户组信息
     * @return array
     */
    public function getRoleById ($roleId) {
        $result = array();
        if ($roleId) {
            $result = DB::select('SELECT * FROM roles WHERE id = :id limit 1',  ['id' => $roleId]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 获取用户信息
     * @return array
     */
    public function getUserInfoById ($id) {
        $result = array();
        if ($id) {
            $result = DB::select('SELECT * FROM users WHERE id = :id limit 1', ['id' => $id]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 更改用户信息
     * @return bool
     */
    public function updateUserInfo ($id, $field) {
        $result = false;
        if ($id && $field) {
            $updatefields = array();
            if (array_key_exists("name", $field)) $updatefields['name'] = $field['name'];
            if (array_key_exists("email", $field)) $updatefields['email'] = $field['email'];
            if (array_key_exists("password", $field)) $updatefields['password'] = $field['password'];
            if (array_key_exists("status", $field)) $updatefields['status'] = $field['status'];
            if (array_key_exists("updated_at", $field)) $updatefields['updated_at'] = time();
            $bindValue = $updatefields;
            $bindValue['id'] = $id;
            $result = DB::update("UPDATE users" . $this->getUpdateSect($updatefields) . " WHERE id = :id", $bindValue);
            if ($result) return true;
        }
        return $result;
    }

    /**
     * @desc 新增用户的所属用户组
     * @return bool
     */
    public function insertUserRole ($userId, $roleId) {
        $result = false;
        if ($userId && $roleId) {
            $result = DB::insert("INSERT into role_user (user_id, role_id) values (?, ?)", [$userId, $roleId]);
            if ($result) return true;
        }
        return $result;
    }

    /**
     * @desc 更新用户的所属用户组
     * @return bool
     */
    public function updateUserRole ($userId, $roleId) {
        $result = false;
        if ($userId && $roleId) {
            $result = DB::insert("UPDATE role_user set role_id = :role_id WHERE user_id = :user_id  limit 1", ['role_id' => $roleId, 'user_id' => $userId]);
            if ($result) return true;
        }
        return $result;
    }


    /**
     * @desc 获取用户列表
     * @return array
     */
    public function getUserList () {
        $result = array();
        $result = DB::select('SELECT * FROM users');
        if ($result) return $this->objectToArray($result);
        return $result;
    }

    /**
     * @desc 获取用户组列表
     * @return array
     */
    public function getRoleList () {
        $result = array();
        $result = DB::select('SELECT * FROM roles');
        if ($result) return $this->objectToArray($result);
        return $result;
    }

    /**
     * @desc 获取用户的应用列表和渠道
     * @dataname role_user
     * @param int roleId 用户id
     * @return array
     */
    public function getUserAppSource ($uid) {
        $result = array();
        if ($uid) {
            $roleAppSource = DB::select("SELECT * FROM user_app_source WHERE user_id = :user_id limit 1", ['user_id' => $uid]);
            if ($roleAppSource) {
                $roleAppSource = (array) $roleAppSource[0];
                $result['user_id'] = $roleAppSource['user_id'];
                $result['app_id'] = json_decode($roleAppSource['app_id'], true);
                $result['source_id'] = json_decode($roleAppSource['source_id'], true);
            }
        }
        return $result;
    }

    /**
     * @desc 插入用户的应用列表和渠道
     * @dataname role_app_source
     * @param int userId 用户组id, array appId 应用id数组, array sourceId 渠道id数组
     * @return array
     */
    public function addUserAppSource ($userId, Array $appId, Array $sourceId) {
        $result = array();
        if ($userId && $appId && $sourceId) {
            $app_id = json_encode($appId);
            $source_id = json_encode($sourceId);
            $result = DB::insert("INSERT into user_app_source (user_id, app_id, source_id) values (?, ?, ?)", [$userId, $app_id, $source_id]);
        }
        if($result) return array('user_id' => $userId, 'app_id' => $appId, 'source_id' => $sourceId);
        return $result;
    }

}
