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
    if(count($_POST['cityId'])){
        $_SESSION['additional_where'] = ' and (';
        $temp = 0;
        foreach ($_POST['cityId'] as $v) {
            if($temp)$_SESSION['additional_where'] .= ' or ';
            $_SESSION['additional_where'] .= 'cityId = ' . $v;
            $temp++;
        }
        $_SESSION['additional_where'] .= ')';
    }


    echo "<script>window.location.replace('$_POST[redirect]');</script>";
}
else
    echo "<script>alert('密码错误!');window.history.go(-1);</script>";