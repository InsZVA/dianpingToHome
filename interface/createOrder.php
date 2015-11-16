<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午11:18
 */
require_once("../admin/model/Model.php");
require_once("sign.php");
require_once("const.php");
$sign = getSign($_POST);
if($sign != $_POST['sign']){echo json_encode(['code'=>'10001']);exit (0);}
$model = new Model('payment');
$data = $_POST;
unset($data['sign']);
unset($data['methodName']);
unset($data['partnerId']);
unset($data['version']);
unset($data['serviceId']);
unset($data['packageId']);
$data['status'] = WAIT_FOR_PAY;
$newId = $model->insert($data);
if($newId)
{
    $json = ['code'=>'0','msg'=>'success','body'=>['orderId'=>$newId]];
}
echo json_encode($json);