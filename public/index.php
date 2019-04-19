<?php
/**
 * Created by PhpStorm.
 * User: wangmengjiao3
 * Date: 2019/4/19
 * Time: 14:04
 */


// 应用目录为当前目录
define('APP_PATH', __DIR__.'/');

// 开启调试模式
define('APP_DEBUG', true);

// 加载框架
$app = require __DIR__.'/../bootstrap/app.php';