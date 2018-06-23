<?php
include "C:/myphp_www/PHPTutorial/WWW/wechat/laravel/vendor/autoload.php";

use Gregwar\Captcha\CaptchaBuilder;

$builder = new CaptchaBuilder;
$builder->build();
session(['codes'=>$builder->getPhrase()]);
header('Content-type: image/jpeg');
$builder->output();