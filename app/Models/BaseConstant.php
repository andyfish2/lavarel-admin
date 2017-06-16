<?php
/**
* 公共配置常量
* @desc 权限点，菜单
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Models;

class BaseConstant
{   
    //分表数
    const HASH_TABLE_NUM = 1;
    const LARGE_HASH_TABLE_NUM = 1;
    const LARGER_HASH_TABLE_NUM = 1;
    const LARGEST_HASH_TABLE_NUM = 1;

    //每页显示数
    const PER_PAGE_NUM = 20;

    //对象转化成数组
    public static function objectToArray($array){
    	if ($array && is_array($array)) {
    		$list = array();
    		foreach ($array as $item) {
    			$list[] = (array) $item;
    		}
    		return $list;
    	}
    }

}
