<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-28
 * Time: 下午1:04
 */
require_once('model/Model.php');
$model = new Model('payment');
$date_now = gmdate("Y-m-d 00:00:00",time()+8*3600);
$today_time = strtotime($date_now);
$cityName=[0=>'','上海','北京','杭州','广州','南京','苏州','深圳','成都','重庆','天津','宁波','扬州','无锡','福州','厦门','武汉','西安','沈阳','大连','青岛','济南','海口','石家庄'];
$accept = [1,3,2,4,7,9,8,16,17,5,11,10,21];
$data = [];
$payment_areas = [];
$colors = ['#f2932d','#f07d35','#c96425','#f09962','#cf2323','#b05f5f','#b03535','#c93825','#eb628d','#eb1a5b','#eb505b','#eb598c','#ec628b'];
$color = 333333;
$i = 0;
foreach($accept as $v)
{
    $additional = "and cityID = " . $v;
    $data[$v]['title'] = $cityName[$v];
    $data[$v]['todayFinished'] = $model->getCount("status = 5 and serviceTime > '$date_now'" . $additional);//今日完成
    $data[$v]['todayCreated'] = $model->getCount("create_time > '$today_time'" . $additional);//今日创建订单
    $payment_areas[] = ['value' => $data[$v]['todayCreated'],'color' => $colors[$i],'title' => $cityName[$v]];
    $color += 2222;
    $data[$v]['todayCanceled'] = $model->getCount("status = 7 and create_time > '$today_time'" . $additional);//今日用户取消订单
    $data[$v]['todayRejected'] = $model->getCount("status = 14 and create_time > '$today_time'" . $additional);//今日拒绝订单
    $data[$v]['todayWaiting'] = $model->getCount("(status=2 or status = 12 or status = 3 or status = 4 or status = 13) and create_time > '$today_time'" . $additional);//今日等待处理
    $i++;
}
$data2 = ['labels' => [],'datasets' => [
		[
            'fillColor' => "rgba(220,220,220,0.5)",
			'strokeColor' => "rgba(220,220,220,1)",
			'pointColor' => "rgba(220,220,220,1)",
			'pointStrokeColor' => "#fff",
			'data' => []
		]]];
for($j = $today_time - 7*3600*24 ;$j <= $today_time;$j += 3600*24)
{
    $data2['labels'][] = gmdate("Y-m-d",$j+8*3600);
    $data2['datasets'][0]['data'][] = $model->getCount("status = 5 and serviceTime like '".gmdate("Y-m-d",$j+8*3600)."%'");
}

echo file_get_contents('header.html');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">今日表格数据</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <td></td>
                            <td>创建订单数</td>
                            <td>用户取消数</td>
                            <td>拒绝服务数</td>
                            <td>今日待处理</td>
                            <td>今日完成数</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($data as $v) {
                            echo "<tr>";
                            echo "<td>$v[title]</td>";
                            echo "<td>$v[todayCreated]</td>";
                            echo "<td>$v[todayCanceled]</td>";
                            echo "<td>$v[todayRejected]</td>";
                            echo "<td>$v[todayWaiting]</td>";
                            echo "<td>$v[todayFinished]</td>";
                            echo "</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">订单分布</div>
                <div class="panel-body">
                    <canvas style="float:left" id="myChart" width="400" height="400"></canvas>
                    <ul style="float:left;margin-left:100px" class="list-group">
                        <?php
                        $i = 0;
                        foreach($payment_areas as $v)
                        {
                            echo "<li class='list-group-item'><span class='badge' style='background-color: $colors[$i];margin-left:20px'>$v[value]</span>$v[title]</li>";
                            $i++;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">本周完成订单数分析</div>
                <div class="panel-body">
                    <canvas style="float:left" id="myChart2" width="800" height="400"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //Get context with jQuery - using jQuery's .get() method.
    var ctx = $("#myChart").get(0).getContext("2d");
    //This will get the first returned node in the jQuery collection.
    var data = <?php echo json_encode($payment_areas);?>;
    var myNewChart = new Chart(ctx).Doughnut(data);
    var ctx2 = $("#myChart2").get(0).getContext("2d");
    var data2 = <?php echo json_encode($data2);?>;
    var myNewChart2 = new Chart(ctx2).Line(data2);
</script>
<?php echo file_get_contents('footer.html');?>