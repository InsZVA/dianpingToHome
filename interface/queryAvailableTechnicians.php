<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午11:18
 */
require_once("../admin/model/Model.php");
require_once("sign.php");
$sign = getSign($_POST);
if($sign != $_POST['sign']){echo json_encode(['code'=>'10001']);exit (0);}
/*
 * 伪造技师
 */
$json = ['code' => '0','msg' => 'success','body' => ['technicianIds'=>['0'] ]];
echo json_encode($json);
exit;
/*
 * 伪造结束
 */
$model = new Model('technician');
$count = (int)$model->getCount("technician.cityId = $_POST[cityId] and technician.productIds like '%$_POST[productId]%'");
$list = [];
if($count) {
    $t_list = $model->getList(['technicianId'],"technician.cityId = $_POST[cityId] and technician.productIds like '%$_POST[productId]%'");
    foreach($t_list as $value)
        $list[] = $value['technicianId'];
}
$json = ['code' => '0', 'msg' => 'success', 'body' =>
    ['totalSize' => $count,
        'technicianIds' => $list]
];
echo json_encode($json);