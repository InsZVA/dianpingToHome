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
 * 无技师概念
 */
$json = ['code' => '20003','msg' => '该服务无技师列表'];
echo json_encode($json);
exit;
/*
 * 结束
 */
$model = new Model('technician');
$count = (int)$model->getCount();
if($count > $_POST['pageSize'])$count = $_POST['pageSize'];
$list = [];
if($count) {
    if($_POST['pageSize'] != '')
        $num = $_POST['pageSize'];
    else
        $num = 50;
    $start = ($_POST['currentPage'] - 1) * $num;
    $list = $model->getList(['*'],'',"$start,$num");
    for ($i = 0; $i < $count; $i++) {
        $list[$i]['cityId'] = (int)$list[$i]['cityId'];
        $list[$i]['age'] = (int)$list[$i]['age'];
        $list[$i]['workingAge'] = (int)$list[$i]['workingAge'];
        $list[$i]['orderAmount'] = (int)$list[$i]['orderAmount'];
        $list[$i]['level'] = (int)$list[$i]['level'];
        $list[$i]['longitude'] = (float)$list[$i]['longitude'];
        $list[$i]['latitude'] = (float)$list[$i]['latitude'];
        //$list[$i]['tags'] = json_decode($list[$i]['tags']);
        $list[$i]['tags'] = [];
        unset($list[$i]['productId']);
    }
}
$json = ['code' => '0', 'msg' => 'success', 'body' =>
    ['totalSize' => $count,
        'technicianList' => $list]
];
echo json_encode($json);