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
$data = ['status'=>SERVICE_FINISHED];
$result = $model->edit("payment.orderId = $_POST[orderId]",$data);
if($result)
{
    $json = ['code'=>'0','msg'=>'success'];
}
echo json_encode($json);