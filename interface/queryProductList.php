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
$model = new Model('product');
$count = (int)$model->getCount("");
$list = [];
if($count) {
    if($_POST['pageSize'] != '')
        $num = $_POST['pageSize'];
    else
        $num = 50;
    $start = ($_POST['currentPage'] - 1) * $num;
    $list = $model->getList(['*'],"","$start,$num");
    for ($i = 0; $i < $count; $i++) {
        //unset($list[$i]['cityId']);
        $list[$i]['orderAmount'] = (int)$list[$i]['orderAmount'];
        $list[$i]['duration'] = (int)$list[$i]['duration'];
        $list[$i]['minOrders'] = (int)$list[$i]['minOrders'];
        $list[$i]['maxOrders'] = (int)$list[$i]['maxOrders'];
        $list[$i]['originalPrice'] = (float)$list[$i]['originalPrice'];
        $list[$i]['settlePrice'] = (float)$list[$i]['settlePrice'];
        $list[$i]['rank'] = (int)$list[$i]['rank'];
        $list[$i]['details'] = json_decode($list[$i]['details'],true);
        $list[$i]['imageUrls'] = json_decode($list[$i]['imageUrls'],true);
    }
}
$json = ['code' => '0', 'msg' => 'success', 'body' =>
    ['totalSize' => $count,
        'productList' => $list]
];
echo json_encode($json);