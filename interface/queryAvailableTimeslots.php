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
if($_POST['longitude'] < 0 || $_POST['longitude'] > 180 || $_POST['latitude'] < 0 || $_POST['latitude'] > 90){echo json_encode(['code'=>'20001']);exit (0);}
$model = new Model('technician');
//$count = (int)$model->getCount("technician.cityId = $_POST[cityId] and technician.productIds like '%$_POST[productId]%'");
$count = 1;
if($count) {
    if($_POST['queryDayNum'] == '')
        $num = 7;
    else
        $num = $_POST['queryDayNum'];
    $timeList = [];
    for($i = 0;$i < $num;$i++)
    {
        $date = gmdate("Y-m-d",time() + 8 * 3600 + $i * 24 * 3600);
        if($i == 0)
        {
            $time = gmdate("H:i:s",time() + 8 * 3600);
            $times = explode(':',$time);
            $n = $times[0] * 2 + $times[1]/30;
            $str = "0000000000";
            for($t = 11;$t <= 44;$t++)
            {
                if($t <= $n+1)
                    $str .= "0";
                else
                    $str .= "1";
            }
            $str .= "0000";
            $timeList[] = ['date'=>$date,'timeslot'=>$str];
        }
        else
        $timeList[] = ['date'=>$date,'timeslot'=>'000000000011111111111111111111111111111111110000'];
    }
    $json = ['code' => '0', 'msg' => 'success', 'body' =>
        ['timeList' => $timeList]
    ];
}
else
    $json = ['code' => '20001'];

echo json_encode($json);