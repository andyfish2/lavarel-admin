<?php
/**
* MainController
* @desc 后台主面板配置信息，左边菜单列表，配置信息设置
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class MainController extends BaseController
{	
	//系统内置管理员(id=1,拥有最高权限)
    private static $systemAdminId = 1;

    //左边菜单，用户信息
    public function index(){
    	//获取全部菜单
        $leftMenu = Admin::getLeftMenu();
        //是否是内置管理员(拥有最高的权限)
        $this->isSystemAdmin = ($this->bkAdminUser['id'] == self::$systemAdminId) ? TRUE : FALSE;
        //根据权限显示菜单
        $permissionMenu = array();
        if ($this->isSystemAdmin) {
        	$permissionMenu = $leftMenu;
        } else {
        	$permission_ids = Admin::getPermissionIds($this->bkAdminUser['id']);
	    	foreach ($leftMenu as $menu) {
	    		if (!$menu['is_display']) continue;
		        if (!in_array($menu['id'], $permission_ids)) continue;
		        $permissionMenu[] = $menu;
		        //$permissionMenu[$menu['id']] = $menu['name'].'_'.$menu['id'];
		        //var_dump($permissionMenu);exit();
		      	// if ($menu['sub']) {
			      //   foreach ($menu['sub'] as $s_k => $subMenu) {
			      //       if (!$subMenu['is_display']) continue;
			      //       if (!$this->isSystemAdmin && !in_array($subMenu['id'], $permission_ids)) continue;
			      //       $permissionMenuHtml .= '<dd style="display: none;">';
			      //       $permissionMenuHtml .= '<ul><li><a href="'.$this->getDeUrl($subMenu['uri_alias'] ? $subMenu['uri_alias'] : '#', array('id' => $subMenu['id'])).'" target="framecontent">'.$subMenu['name'].'</a></li></ul>';
			      //       $permissionMenuHtml .= '</dd>';
			      //   }
		       //  }
		    }	
        }
        $data = array();
        //var_dump($permissionMenu);
        //var_dump($permissionMenuHtml);
    	$data['userinfo'] = $this->bkAdminUser;
    	return view('admin.main.main', $data);
    }
}
