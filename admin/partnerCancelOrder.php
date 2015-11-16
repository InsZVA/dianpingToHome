<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-6
 * Time: 下午2:08
 */
require_once('access.php');
if(isset($_GET['orderId']))
{
    require_once('../interface/sign.php');
    require_once('httpPost.php');
    require_once('loadOrderInfo.php');
    $_GET['methodName'] = 'partnerCancelOrder';
    $_GET['sign'] = getSign($_GET);
    httpPost('http://m.api.dianping.com/tohome/openapi/exiugezi/',$_GET);
    updateOrder($_GET['orderId']);
    echo "<script>window.location.replace('orderList.php');</script>";
    exit(0);
}
