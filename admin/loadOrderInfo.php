<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-7
 * Time: 下午12:54
 */
require_once('access.php');
require_once('httpPost.php');
require_once('model/Model.php');
require_once('../interface/sign.php');
/**
 * @param $orderId
 * @param bool|false $debug
 * @return bool|mysqli_result
 */
function updateOrder($orderId,$debug = false)
{
    $array = ['orderId' => $orderId,'methodName' => 'loadOrderInfo'];
    $array['sign'] = getsign($array);
    $data = httpPost("http://m.api.dianping.com/tohome/openapi/exiugezi/",$array);
    $data = json_decode($data,true);
    $data = $data['body'];
    unset($data['serviceId']);
    unset($data['packageId']);
    if($debug)var_dump($data);
    $model = new Model('payment');
    return $model->edit('orderId = '.$orderId,$data,$debug);
}