<?php

/**
 * Created by PhpStorm.
 * User: wangmengjiao3
 * Date: 2019/4/19
 * Time: 14:17
 */

class Controller
{

    protected $_controller;
    protected $_action;
    protected $_view;

    // 构造函数，初始化属性，并实例化对应模型
    function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    function set($name, $value)
    {
        $this->_view->set($name, $value);
    }

    function __destruct()
    {
        $this->_view->render();
    }

}