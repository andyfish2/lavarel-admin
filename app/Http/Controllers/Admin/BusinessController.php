<?php
/**
* BusinessController
* @desc 市场
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessController extends BaseController
{
    /**
     * @desc 获取市场的原始数据
     * @return view
     */
    public function inside(Request $request)
    {	
    	$year = $request->input('year');
    	$month = $request->input('month');
    	$appId = $request->input('appList');
    	$sourceId = $request->input('sourceList');

        $data = array();
        $search = array();
        $search['year'] = $year;
        $search['month'] = $month;
        $search['appId'] = $appId ? json_encode(explode(',', $appId)) : '[]';
        $search['sourceId'] = $sourceId ? json_encode(explode(',', $sourceId)) : '[]';
    	if ($appId && $sourceId) {
            $year = (int) $year;
            $month = (int) $month;
    		if($sourceId) {
                $sourcelist = explode(',', $sourceId);
                $sourceId = '';
                foreach ($sourcelist as $value) {
                    $sourceId .= "'" . $value . "'";
                }
            }
    		if ($month) {
    			//年月都有情况，数据按每月的天数显示
    			$newUser = $this->getBusinessService()->getNewUserByYearAndMonth($year, $month, $appId, $sourceId);//新增用户，设备
    			$activeUser = $this->getBusinessService()->getActiveUserByYearAndMonth($year, $month, $appId, $sourceId);//活跃用户，设备
    			$currencyAmount = $this->getBusinessService()->getAmountByYearAndMonth($year, $month, $appId, $sourceId);//订单总额
                $count = date('t', strtotime($year . '-' . $month));
                $field = 'day';
    		} else {
    			//只有年的情况，数据按月显示
    			$newUser = $this->getBusinessService()->getNewUserByYear($year, $appId, $sourceId);//新增用户，设备
    			$activeUser = $this->getBusinessService()->getActiveUserByYear($year, $appId, $sourceId);//活跃用户，设备
    			$currencyAmount = $this->getBusinessService()->getAmountByYear($year, $appId, $sourceId);//订单总额
                $count = 12;
                $field = 'month';
    		}
            for ( $i = 1; $i <= $count; $i++) { 
                $data[$i] = array(
                    'day' => $i,
                    'newUser' => $newUser ? $this->checkdate($newUser, $field, $i)['uidNum'] : 0, //新增用户
                    'newUUID' => $newUser ? $this->checkdate($newUser, $field, $i)['UUIDNum'] : 0,//新增设备
                    'activeUser' => $activeUser ? $this->checkdate($activeUser, $field, $i)['uidNum'] : 0,//活跃用户
                    'activeUUID' => $activeUser ? $this->checkdate($activeUser, $field, $i)['UUIDNum'] : 0,//活跃设备
                    'totalAmount' => $currencyAmount ? $this->checkdate($currencyAmount, $field, $i, true)['totalAmount'] : 0,//订单总金额
                );
            }
    	}
        return view('admin.business.inside', ['inside' => $data, 'search' => $search]);
    }

    /**
     * @desc 获取市场的对外数据
     * @return view
     */
    public function outside(Request $request)
    {   
        $year = $request->input('year');
        $month = $request->input('month');
        $appId = $request->input('appList');
        $sourceId = $request->input('sourceList');

        $data = array();
        $outside = array();
        $search['year'] = $year;
        $search['month'] = $month;
        $search['appId'] = $appId;
        $search['sourceId'] =  "'" . $sourceId  . "'";
        if ($appId && $sourceId && $month && $year) {
            $year = (int) $year;
            $month = (int) $month;
            $source_id = "'" . $sourceId  . "'";
            //数据按每月的天数显示
            $newUser = $this->getBusinessService()->getNewUserByYearAndMonth($year, $month, $appId, $source_id);//新增用户，设备
            $activeUser = $this->getBusinessService()->getActiveUserByYearAndMonth($year, $month, $appId, $source_id);//活跃用户，设备
            $currencyAmount = $this->getBusinessService()->getAmountByYearAndMonth($year, $month, $appId, $source_id);//订单总额
            //$beginTime = $year . '-' . $month . '-01 00:00:00';
            //$endTime = $year . '-' . $month . '-' . date('t', strtotime($year . '-' . $month)) . ' 00:00:00';
            
            $count = date('t', strtotime($year . '-' . $month));
            $field = 'day';
            for ( $i = 1; $i <= $count; $i++) { 
                $data[$i] = array(
                    'day' => $i,
                    'newUser' => $newUser ? $this->checkdate($newUser, $field, $i)['uidNum'] : 0, //新增用户
                    'newUUID' => $newUser ? $this->checkdate($newUser, $field, $i)['UUIDNum'] : 0,//新增设备
                    'activeUser' => $activeUser ? $this->checkdate($activeUser, $field, $i)['uidNum'] : 0,//活跃用户
                    'activeUUID' => $activeUser ? $this->checkdate($activeUser, $field, $i)['UUIDNum'] : 0,//活跃设备
                    'totalAmount' => $currencyAmount ? $this->checkdate($currencyAmount, $field, $i, true)['totalAmount'] : 0,//订单总金额
                );
            }
            //扣量统计
            $beginTime = $year . '-' . $month . '-01 00:00:00';//这个月的开始时间
            $endTime = $year . '-' . $month . '-' . date('t', strtotime($year . '-' . $month)) . ' 00:00:00';//这个月的结束时间
            $businessOutSideConfig = $this->getBusinessService()->getBusinessOutSideConfigByMonth($appId, $sourceId, $beginTime, $endTime);
            if ($data && $businessOutSideConfig) {
                $bool = false;
                $before = $center = $after = array();
                $beginTime = strtotime($beginTime);
                $endTime = strtotime($endTime);
                foreach ($businessOutSideConfig as $item) {
                    $newUser_per = $item['newUser_per'];
                    $totalAmount_per = $item['totalAmount_per'];
                    $begin_time = strtotime($item['begin_time']);
                    $end_time = strtotime($item['end_time']);
                    
                    if ($begin_time <= $beginTime && $end_time >= $endTime) {
                        //这个月都要扣量 
                        $bool = true;
                        break;
                    }
                    if ($begin_time <= $beginTime && $end_time < $endTime) {
                        //这个月前部分扣量
                        $days = date('d', $end_time);
                        for ( $i = 1; $i <= $days ; $i++) { 
                            $before[$i] = array('day' => $i, 'newUser_per' => $newUser_per, 'totalAmount_per' => $totalAmount_per);
                        }
                    }
                    if ($begin_time >= $beginTime && $end_time < $endTime) {
                        //这个月中部分扣量
                        $beginDay = date('d', $begin_time);
                        $endDay = date('d', $end_time);
                        for ( $i = $beginDay; $i <= $endDay ; $i++) { 
                            $center[$i] = array('day' => $i, 'newUser_per' => $newUser_per, 'totalAmount_per' => $totalAmount_per);
                        }
                    }
                    if ($begin_time >= $beginTime && $end_time > $endTime) {
                        //这个月后部分扣量
                        $beginDay = date('d', $begin_time);
                        for ( $i = $beginDay; $i <= date('t', strtotime($year . '-' . $month)) ; $i++) { 
                            $after[$i] = array('day' => $i, 'newUser_per' => $newUser_per, 'totalAmount_per' => $totalAmount_per);
                        }
                    }
                }

                if ($bool) {
                    foreach ($data as $value) {
                        $outside[$value['day']] = array(
                            'day' => $value['day'],
                            'newUser' => $value['newUser'] - $value['newUser']*$newUser_per > 0 ? (int) ceil(($value['newUser'] - $value['newUser']*$newUser_per)) : 0, //新增用户
                            'newUUID' => $value['newUUID'],//新增设备
                            'activeUser' => $value['activeUser'],//活跃用户
                            'activeUUID' => $value['activeUUID'],//活跃设备
                            'totalAmount' => $value['totalAmount'] - $value['totalAmount']*$totalAmount_per > 0 ? round($value['totalAmount'] - $value['totalAmount']*$totalAmount_per, 2) : 0,//订单总金额
                        );
                    }
                }else{
                    $list = array_merge($before, $center, $after);
                    if ($list) {
                        foreach ($data as $key => $value) {
                            $flag = true;
                            foreach ($list as $key => $item) {
                                if ($value['day'] == $item['day']) {
                                    $outside[$value['day']] = array(
                                        'day' => $value['day'],
                                        'newUser' => $value['newUser'] - $value['newUser']*$item['newUser_per'] > 0 ? (int) ceil(($value['newUser'] - $value['newUser']*$item['newUser_per'])) : 0, //新增用户
                                        'newUUID' => $value['newUUID'],//新增设备
                                        'activeUser' => $value['activeUser'],//活跃用户
                                        'activeUUID' => $value['activeUUID'],//活跃设备
                                        'totalAmount' => $value['totalAmount'] - $value['totalAmount']*$item['totalAmount_per'] > 0 ? round($value['totalAmount'] - $value['totalAmount']*$item['totalAmount_per'], 2) : 0,//订单总金额
                                    );
                                    $flag = false;
                                    break;
                                }
                            }
                            if ($flag) {
                                $outside[$value['day']] = $value;
                            }
                        }
                        ksort($outside);
                    }
                }
            }
        }
        return view('admin.business.outside', ['outside' => $outside, 'search' => $search]);
    }

    /**
     * @desc 合作渠道cpa 数据
     * @return view
     */
    public function cpa(Request $request)
    {   
        $year = $request->input('year', $this->getYearMonthHour()['year']);
        $month = $request->input('month', 0);
        $appId = $request->input('appId', 0);
        $sourceId = $request->input('sourceId', 0);

        $year = 2013;
        $appId = '1000';
        $month = 10;
        $sourceId = "'a_01'";
        if ($appId && $sourceId) {
            $data = array();
            if ($month) {
                //年月都有情况，数据按每月的天数显示
                $newUser = $this->getBusinessService()->getNewUserByYearAndMonth($year, $month, $appId, $sourceId);//新增用户，设备
                $activeUser = $this->getBusinessService()->getActiveUserByYearAndMonth($year, $month, $appId, $sourceId);//活跃用户，设备
                $count = date('t', strtotime($year . '-' . $month));
                $field = 'day';
            } else {
                //只有年的情况，数据按月显示
                $newUser = $this->getBusinessService()->getNewUserByYear($year, $appId, $sourceId);//新增用户，设备
                $activeUser = $this->getBusinessService()->getActiveUserByYear($year, $appId, $sourceId);//活跃用户，设备
                $count = 12;
                $field = 'month';
            }
            for ( $i = 1; $i <= $count; $i++) { 
                $data[$i] = array(
                    'day' => $i,
                    'newUser' => $newUser ? $this->checkdate($newUser, $field, $i)['uidNum'] : 0, //新增用户
                    'newUUID' => $newUser ? $this->checkdate($newUser, $field, $i)['UUIDNum'] : 0,//新增设备
                    'activeUser' => $activeUser ? $this->checkdate($activeUser, $field, $i)['uidNum'] : 0,//活跃用户
                    'activeUUID' => $activeUser ? $this->checkdate($activeUser, $field, $i)['UUIDNum'] : 0,//活跃设备
                );
            }
            return view('admin.business.inside', ['inside' => $data]);
        }
    }

    /**
     * @desc  * @desc 合作渠道cps 数据
     * @return view
     */
    public function cps(Request $request)
    {   
        $year = $request->input('year', $this->getYearMonthHour()['year']);
        $month = $request->input('month', 0);
        $appId = $request->input('appId', 0);
        $sourceId = $request->input('sourceId', 0);

        $year = 2013;
        $appId = '1000';
        $month = 10;
        $sourceId = "'a_01'";
        if ($appId && $sourceId) {
            $data = array();
            if ($month) {
                //年月都有情况，数据按每月的天数显示
                $newUser = $this->getBusinessService()->getNewUserByYearAndMonth($year, $month, $appId, $sourceId);//新增用户，设备
                $activeUser = $this->getBusinessService()->getActiveUserByYearAndMonth($year, $month, $appId, $sourceId);//活跃用户，设备
                $count = date('t', strtotime($year . '-' . $month));
                $field = 'day';
            } else {
                //只有年的情况，数据按月显示
                $newUser = $this->getBusinessService()->getNewUserByYear($year, $appId, $sourceId);//新增用户，设备
                $activeUser = $this->getBusinessService()->getActiveUserByYear($year, $appId, $sourceId);//活跃用户，设备
                $count = 12;
                $field = 'month';
            }
            for ( $i = 1; $i <= $count; $i++) { 
                $data[$i] = array(
                    'day' => $i,
                    'newUser' => $newUser ? $this->checkdate($newUser, $field, $i)['uidNum'] : 0, //新增用户
                    'newUUID' => $newUser ? $this->checkdate($newUser, $field, $i)['UUIDNum'] : 0,//新增设备
                    'activeUser' => $activeUser ? $this->checkdate($activeUser, $field, $i)['uidNum'] : 0,//活跃用户
                    'activeUUID' => $activeUser ? $this->checkdate($activeUser, $field, $i)['UUIDNum'] : 0,//活跃设备
                );
            }
            return view('admin.business.inside', ['inside' => $data]);
        }
    }


    /**
     * @desc 获取月份数据
     * @param array 数组, int data 月份或者天数, $bool true.计算金额, false.用户设备
     * @return array
     */
    private function checkdate($checkArray, $field, $id, $bool = false){
    	$list = array();
    	if ($checkArray && $field) {
    		$monthArray = array_column($checkArray, $field);
    		if (in_array($id, $monthArray)) {
    			foreach ($checkArray as $item) {
    				if ($item[$field] == $id) {
    					if ($bool) {
    						$list['totalAmount'] = $item['totalAmount'];
    					} else {
							$list['uidNum'] = $item['uidNum'];
    						$list['UUIDNum'] = $item['UUIDNum'];
    					}
    				}
    			}
    		}
    	}
    	if (!$list) $list = array('uidNum' => 0, 'UUIDNum' => 0, 'totalAmount' => '0.00');
    	return $list;
    }

    /**
     * @desc 补全所有月份数据
     * @param array 要补全的数组, $bool true.金额补全, false.用户设备补全
     * @return view
     */
    // private function getMonthArray($array, $bool = false){
    // 	$list = array();
    // 	if ($array && is_array($array)) {
    // 		$month = array_column($array, 'month');
    //         for ($i=1; $i <= 12 ; $i++) { 
    //             if (!in_array($i,$month)) {
    //             	if ($bool) {
    //             		$list[$i] = array('month' => $i, 'totalAmount' => '0.00');
    //             	}else{
    //             		$list[$i] = array('month' => $i, 'uidNum' => 0, 'UUIDNum' => 0);
    //             	}
    //             }
    //         }
    //         foreach ($array as $key => $item) {
    //             $list[$item['month']] = $item;
    //         }
    //         if($list) ksort($list);
    // 	}
    // 	return $list;
    // }
}
