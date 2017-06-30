<?php
/**
* config配置
* @desc 权限点，菜单
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Business extends BaseConstant
{   
    /**
     * @desc 一年的12个月新增用户数，新增设备数
     * @dataname account_registration_app
     * @param int year 年份, string $appId 应用, string $sourceId 设备
     * @return array
     */
    public function getNewUserByYear ($year, $appId, $sourceId) {
        $result = array();
        if ($year && $appId && $sourceId) {
            $result  = DB::select("SELECT DATE_FORMAT(RegDate,'%m') as month, count(distinct UserID) as uidNum, count(distinct RegUUID) as UUIDNum FROM account_registration_app WHERE DATE_FORMAT(RegDate,'%Y') = :year and AppID in (" . $appId . ") and RegSource in (" . $sourceId . ") group by DATE_FORMAT(RegDate,'%m') ORDER BY month asc limit 12", ['year' => $year]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 一年每个月每天的新增用户数，新增设备数
     * @dataname account_registration_app
     * @param int year 年份, int month 月份, string $appId 应用, string $sourceId 设备
     * @return array
     */
    public function getNewUserByYearAndMonth ($year, $month, $appId, $sourceId) {
        $result = array();
        if ($year && $month && $appId && $sourceId) {
            $result  = DB::select("SELECT DATE_FORMAT(RegDate,'%d') as day, count(distinct UserID) as uidNum, count(distinct RegUUID) as UUIDNum FROM account_registration_app WHERE DATE_FORMAT(RegDate,'%Y') = :year and DATE_FORMAT(RegDate,'%m') = :month and AppID in (" . $appId . ") and RegSource in (" . $sourceId . ") group by DATE_FORMAT(RegDate,'%d') ORDER BY day asc limit 31", ["year" => $year, "month" => $month]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 一年的12个月活跃用户数，活跃设备数
     * @dataname account_registration_app
     * @param int year 年份, string $appId 应用, string $sourceId 设备
     * @return array
     */
    public function getActiveUserByYear ($year, $appId, $sourceId) {
        $result = array();
        if ($year && $appId && $sourceId) {
            $result  = DB::select("SELECT DATE_FORMAT(Date,'%m') as month, count(distinct UserID) as uidNum, count(distinct UUID) as UUIDNum FROM record_date_login WHERE DATE_FORMAT(Date,'%Y') = :year and AppID in (". $appId . ") and Source in (" . $sourceId . ") group by DATE_FORMAT(Date,'%m') ORDER BY month asc limit 12", ['year' => $year]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 一年每个月每天的活跃用户数，活跃设备数
     * @dataname account_registration_app
     * @param int year 年份, int month 月份, string $appId 应用, string $sourceId 设备
     * @return array
     */
    public function getActiveUserByYearAndMonth ($year, $month, $appId, $sourceId) {
        $result = array();
        if ($year && $month && $appId && $sourceId) {
            $result  = DB::select("SELECT DATE_FORMAT(Date,'%d') as day, count(distinct UserID) as uidNum, count(distinct UUID) as UUIDNum FROM record_date_login WHERE DATE_FORMAT(Date,'%Y') = :year and DATE_FORMAT(Date,'%m') = :month and AppID in (". $appId . ") and Source in (" . $sourceId . ") group by DATE_FORMAT(Date,'%d') ORDER BY day asc limit 31", ['year' => $year, 'month' => $month]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 一年的12个月每月订单总金额数
     * @dataname pay_order_confirm
     * @param int year 年份, string $appId 应用, string $sourceId 设备
     * @return array
     */
    public function getAmountByYear ($year, $appId, $sourceId) {
        $result = array();
        if ($year && $appId && $sourceId) {
            $result  = DB::select("SELECT DATE_FORMAT(SubmitTime,'%m') as month, sum(case when CurrencyType='USD' then CurrencyAmount*6 else CurrencyAmount end ) as totalAmount FROM pay_order_confirm WHERE DATE_FORMAT(SubmitTime,'%Y') = :year and AppID in (". $appId . ") and Source in (" . $sourceId . ") group by DATE_FORMAT(SubmitTime,'%m') ORDER BY month asc limit 12", ['year' => $year]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

    /**
     * @desc 一年每个月每天的订单总金额数
     * @dataname pay_order_confirm
     * @param int year 年份, int month 月份, string $appId 应用, string $sourceId 设备
     * @return array
     */
    public function getAmountByYearAndMonth ($year, $month, $appId, $sourceId) {
        $result = array();
        if ($year && $month && $appId && $sourceId) {
            $result  = DB::select("SELECT DATE_FORMAT(SubmitTime,'%d') as day, sum(case when CurrencyType='USD' then CurrencyAmount*6 else CurrencyAmount end) as totalAmount FROM pay_order_confirm WHERE DATE_FORMAT(SubmitTime,'%Y') = :year and DATE_FORMAT(SubmitTime,'%m') = :month and AppID in (". $appId . ") and Source in (" . $sourceId . ") group by DATE_FORMAT(SubmitTime,'%d') ORDER BY day asc limit 31", ['year' => $year, 'month' => $month]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }


    // /**
    //  * @desc 获取市场数据对外扣量规则（查询扣量规则表）
    //  * @dataname business_outside_config
    //  * @param int year 年份, int month 月份, string $appId 应用, string $sourceId 设备
    //  * @return array
    //  */
    // public static function getBusinessOutSideConfigByAppidAndSourceId ($appId, $sourceId, $beginTime, $endTime) {
    //     $result = array();
    //     if ($appId && $sourceId && $beginTime && $endTime) {
    //         $result  = DB::select("SELECT * FROM business_outside_config WHERE app_id = :appId AND source_id = :sourceId AND begin_time >= :beginTime AND end_time <= :endTime", ['appId' => $appId, 'sourceId' => $sourceId, 'beginTime' => $beginTime, 'endTime' => $endTime]);
    //         if ($result) return $this->objectToArray($result);
    //     }
    //     return $result;
    // }

    /**
     * @desc 获取市场数据对外扣量规则
     * @dataname business_outside_config
     * @param int appid 应用id, int sourceId 渠道id, datetime begintime 一个月的开始时间, datetime endtime 一个月的结束时间
     * @return array
     */
    public function getBusinessOutSideConfigByMonth ($appId, $sourceId, $beginTime, $endTime) {
        $result = array();
        if ($appId && $sourceId && $beginTime && $endTime) {
            $result  = DB::select("SELECT * FROM business_outside_config WHERE app_id = :appId AND source_id = :sourceId AND begin_time <= :endTime AND end_time >= :beginTime order by begin_time asc", ['appId' => $appId, 'sourceId' => $sourceId, 'beginTime' => $beginTime, 'endTime' => $endTime ]);
            if ($result) return $this->objectToArray($result);
        }
        return $result;
    }

}
