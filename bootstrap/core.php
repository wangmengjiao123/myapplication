<?php
/**
 * Created by PhpStorm.
 * User: wangmengjiao3
 * Date: 2019/4/19
 * Time: 14:12
 */
class Test {

    // 运行程序
    function run() {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->callUri();
    }

    //处理uri
    function callUri() {

        if (!empty($_GET['url'])){
            $url = $_GET['url'];
            $urlArray = explode("/",$url);

            // 获取控制器名
            $controllerName = ucfirst(empty($urlArray[0]) ? 'Index' : $urlArray[0]);
            $controller = $controllerName . 'Controller';

            // 获取动作名
            array_shift($urlArray);
            $action = empty($urlArray[0]) ? 'index' : $urlArray[0];

            //获取URL参数
            array_shift($urlArray);
            $queryString = empty($urlArray) ? array() : $urlArray;
        }

        // 数据为空的处理
        $action = empty($action) ? 'index' : $action;
        $queryString  = empty($queryString) ? array() : $queryString;

        // 实例化控制器
        $int = new $controller($controllerName, $action);

        // 如果控制器存和动作存在，这调用并传入URL参数
        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($int, $action), $queryString);
        } else {
            exit($controller . "控制器不存在");
        }
    }

    //是否打开debug
    function setReporting() {
        if (APP_DEBUG == true) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', RUNTIME_PATH. 'logs/error.log');
        }
    }

    //自动加载控制器和模型类
    static function loadClass($class) {
        $frameworks = ROOT . $class . EXT;
        $controllers = APP_PATH . 'application/controllers/' . $class . EXT;
        $models = APP_PATH . 'application/models/' . $class . EXT;

        if (file_exists($frameworks)) {
            // 加载框架核心类
            include $frameworks;
        } elseif (file_exists($controllers)) {
            // 加载应用控制器类
            include $controllers;
        } elseif (file_exists($models)) {
            //加载应用模型类
            include $models;
        } else {

        }
    }
}