<?php
/**
* model 工厂类
* @desc 
* @author chenlidong
* @since 2017/06/06
*/
namespace App\Models;

use App\Models\Admin;


final class ServiceFactory
{   
    protected static $instance = null;

    protected static $services = array();

    public static function getInstance() {
        if (!self::$instance) {
          self::$instance = new ServiceFactory();
        }
        return self::$instance;
    }

    /**
     * @return AdminService
     */
    public function createAdminService() {
        if (!isset(self::$services["Admin"])) {
          self::$services["Admin"] = new Admin();
        }
        return self::$services["Admin"];
    } 

    /**
     * @return BusinessService
     */
    public function createBusinessService() {
        if (!isset(self::$services["Business"])) {
          self::$services["Business"] = new Business();
        }
        return self::$services["Business"];
    } 
}
