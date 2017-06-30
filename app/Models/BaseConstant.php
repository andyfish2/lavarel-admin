<?php
/**
* 公共配置常量
* @desc model公用部分
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

    /**
     * 对象变成数组
     * @param Array $fields 
     * @return array
     */
    public function objectToArray(Array $fields){
    	if ($fields && is_array($fields)) {
    		$list = array();
    		foreach ($fields as $item) {
    			$list[] = (array) $item;
    		}
    		return $list;
    	}
    }

    /**
     * sql 绑定数据
     * @param Array $fields 一个字段的map,每个条目由key和value组成。其中key为字段名，value为字段值
     * @return String 绑定子句
     */
    public function bindValues(Array $fields) {
        $bindValues = array();
        foreach ( $fields as $key => $value ) {
            $bindValues =  "'". $key . "'" . '=>' . $value;
        }
        return $bindValues;
    }

    /**
     * 获得更新语句中的set子句，如：set a=1,b='ket'
     * @param Array $fields 一个字段的map,每个条目由key和value组成。其中key为字段名，value为字段值
     * @return String set子句
     */
    public function getUpdateSect(Array $fields) {
        $updateSect = ' SET ';
        foreach ( array_keys($fields) as $key ) {
            $updateSect .= '`' . $key . '` = :' . $key . ',';
        }
        return substr_replace($updateSect, '', -1);
    }


}
