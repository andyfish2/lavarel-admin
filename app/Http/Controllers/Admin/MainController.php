<?php
/**
* MainController
* @desc 后台主面板配置信息，左边菜单列表，配置信息设置
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MainController extends BaseController
{	
	//系统内置管理员(id=1,拥有最高权限)
    private static $systemAdminId = 1;

    /**
     * @desc 欢迎页
     * @return view
     */
    public function index(){
    	//获取全部菜单
     //    $leftMenu = $this->getAdminService()->getLeftMenu();
     //    //是否是内置管理员(拥有最高的权限)
     //    $this->isSystemAdmin = ($this->bkAdminUser['id'] == self::$systemAdminId) ? TRUE : FALSE;
     //    //根据权限显示菜单
     //    $permissionMenu = array();
     //    if ($this->isSystemAdmin) {
     //    	$permissionMenu = $leftMenu;
     //    } else {
     //    	$permission_ids = $this->getAdminService()->getPermissionIds($this->bkAdminUser['id']);
	    // 	foreach ($leftMenu as $menu) {
	    // 		if (!$menu['is_display']) continue;
		   //      if (!in_array($menu['id'], $permission_ids)) continue;
		   //      $permissionMenu[] = $menu;
		   //      //$permissionMenu[$menu['id']] = $menu['name'].'_'.$menu['id'];
		   //      //var_dump($permissionMenu);exit();
		   //    	// if ($menu['sub']) {
			  //     //   foreach ($menu['sub'] as $s_k => $subMenu) {
			  //     //       if (!$subMenu['is_display']) continue;
			  //     //       if (!$this->isSystemAdmin && !in_array($subMenu['id'], $permission_ids)) continue;
			  //     //       $permissionMenuHtml .= '<dd style="display: none;">';
			  //     //       $permissionMenuHtml .= '<ul><li><a href="'.$this->getDeUrl($subMenu['uri_alias'] ? $subMenu['uri_alias'] : '#', array('id' => $subMenu['id'])).'" target="framecontent">'.$subMenu['name'].'</a></li></ul>';
			  //     //       $permissionMenuHtml .= '</dd>';
			  //     //   }
		   //     //  }
		   //  }
     //    }
     //    $data = array();
     //    //var_dump($permissionMenu);exit();
     //    //var_dump($permissionMenuHtml);
    	// $data['userinfo'] = $this->bkAdminUser;
     //    $data['menus'] = $permissionMenu;
        //var_dump($data);exit();
    	return view('admin.main.main');
    }

    /**
     * @desc 左边导航菜单，面包屑
     * @return view
     */
    public function compose(View $view) {
        // $a = $this->getAdminService()->getAppList();
        // $b =array();
        // foreach ($a as $key => $value) {
        //      array_push($b,$value['AppID']);
        // }
        // var_dump(json_encode($b));exit();




        //获取全部菜单
        $leftMenu = $this->getAdminService()->getLeftMenu();
        //是否是内置管理员(拥有最高的权限)
        $this->isSystemAdmin = (Auth::id() == self::$systemAdminId) ? TRUE : FALSE;
        //根据权限显示菜单
        $permissionMenu = array();
        if ($this->isSystemAdmin) {
            $permissionMenu = $leftMenu;
        } else {
            $permission_ids = $this->getAdminService()->getPermissionIds(Auth::id());
            foreach ($leftMenu as $menu) {
                if (!$menu['is_display']) continue;
                if (!in_array($menu['id'], $permission_ids)) continue;
                $permissionMenu[] = $menu;
            }
        }

        //获取用户的应用列表和渠道
        $userAppSource = $this->getAdminService()->getUserAppSource(Auth::id());
        $appSource = array();
        if ($userAppSource) {
            foreach ($userAppSource as $key => $item) {
                if ($key == 'app_id') {
                    if($item){
                        foreach ($item as $appkey => $appid) {
                            $app = $this->getAdminService()->getAppByID($appid);
                            if ($app) $appSource['app'][$appkey] = array('value' => $appid, 'label' => $app['AppName']);
                        }
                    };
                }
                if ($key == 'source_id') {
                    if($item){
                        foreach ($item as $sourcekey => $sourceid) {
                            $source = $this->getAdminService()->getSourceByID($sourceid);
                            if ($app) $appSource['source'][$sourcekey] = array('value' => $sourceid, 'label' => $source['SourceName']);
                        }
                    };
                }
            }
        }

        $data = array();
        $data['userInfo'] = Auth::user();//个人信息
        $data['bkAdminUri'] = Route::getCurrentRoute()->uri;//当前访问的url
        $data['menus'] = $permissionMenu;//菜单
        $data['appSource'] = $appSource;//用户拥有的应用列表和渠道
        $view->with($data);//填充数据
    }
}
