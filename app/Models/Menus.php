<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

final class Menus
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
    protected $hidden = [
        
    ];

    /**
     * @desc 左侧菜单(权限点)
     * @return array
     */
    public static function getLeftMenu () {
        $leftMenus = array();
        $menus = self::getAdminMenus();
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
    private static function getAdminMenus(){
        $menus = array();
        $menus = DB::select("SELECT * FROM permissions ORDER BY order_id ASC");
        return $menus;
    }

    /**
     * @desc 获取用户的权限id
     * @return array
     */
    public static function getPermissionIds ($uid) {
        $permission = array();
        if ($uid) {
            $roleId = self::getRole($uid);
            if ($roleId) $permissionIds = DB::select('SELECT permission_id FROM permission_role WHERE role_id = :role_id',  ['role_id' => $roleId]);
            if ($permissionIds) {
                $permission = array();
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
    public static function getRole ($uid) {
        $roleId = 0;
        if ($uid) {
            $roleId = DB::select('SELECT role_id FROM role_user WHERE user_id = :user_id limit 1',  ['user_id' => $uid]);
            if ($roleId) {
                $role_id = (array) $roleId[0];
                return $role_id['role_id'];
            }
        }
    }

}
