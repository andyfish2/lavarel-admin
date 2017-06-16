<?php
/**
* config配置
* @desc 权限点，菜单
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Config extends BaseConstant
{   
    /**
     * @desc 获取用户组的应用列表和渠道
     * @dataname role_user
     * @param int roleId 用户id
     * @return array
     */
    public static function getRoleAppSource ($uid) {
        $result = array();
        if ($uid) {
            $roleId = DB::select('SELECT role_id FROM role_user WHERE user_id = :user_id limit 1',  ['user_id' => $uid]);
            if ($roleId) {
                $role_id = (array) $roleId[0];
                $roleAppSource = DB::select("SELECT * FROM role_app_source WHERE role_id = :role_id limit 1", ['role_id' => $role_id['role_id']]);
                if ($roleAppSource) {
                    $roleAppSource = (array) $roleAppSource[0];
                    $result['role_id'] = $roleAppSource['role_id'];
                    $result['app_id'] = json_decode($roleAppSource['app_id'], true);
                    $result['source_id'] = json_decode($roleAppSource['source_id'], true);
                }
            }
        }
        return $result;
    }

    /**
     * @desc 插入用户组的应用列表和渠道
     * @dataname role_app_source
     * @param int roleId 用户组id, array appId 应用id数组, array sourceId 渠道id数组
     * @return array
     */
    public static function addRoleAppSource ($roleId, Array $appId, Array $sourceId) {
        $result = array();
        if ($roleId && $appId && $sourceId) {
            $app_id = json_encode($appId);
            $source_id = json_encode($sourceId);
            $result = DB::insert("INSERT into role_app_source (role_id, app_id, source_id) values (?, ?, ?)", [$roleId, $app_id, $source_id]);
        }
        if($result) return array('role_id' => $roleId, 'app_id' => $appId, 'source_id' => $sourceId);
        return $result;
    }
}
