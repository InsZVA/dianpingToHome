<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-12
 * Time: 下午3:06
 */
session_start();
if($_POST['password'] == '9f11482b4a0a77ff68d0d87684db1cd6')
{
    $_SESSION['admin'] = rand();
    echo "<script>window.location.replace('$_POST[redirect]');</script>";
}
else
    echo "<script>alert('密码错误!');window.history.go(-1);</script>";