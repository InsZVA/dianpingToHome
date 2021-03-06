<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午10:07
 */
require_once('access.php');
require_once('model/Model.php');
require_once('cityId.php');
require_once('orderStatus.php');
$model = new Model('payment');
echo file_get_contents('header.html');
if(!isset($_GET['num']) || $_GET['num'] == '')
    $num = 10;
else
    $num = $_GET['num'];
if(!isset($_GET['page']) || $_GET['page'] == '')
    $_GET['page'] = 1;
$start = ($_GET['page']-1) * $num;

?>
<script>setInterval(function(){window.location.reload();},30000);</script>
<div class="container-fluid">
    <div class="row">
            <form action="masterList.php" method="get">
                <div class="col-md-1 text-center">第</div><div class="col-md-2 text-center"><input type="number" name="page" class="form-control"></div><div class="col-md-1 text-center">页</div>
                <div class="col-md-1 text-center">每页</div><div class="col-md-2"><input type="number" name="num" class="form-control"></div><div class="col-md-1 text-center">条数据</div>
                <div class="col-md-2"><input type="submit" value="查询"></div>
            </form>

    </div>
    <table class="table">
        <thead>
            <tr>
                <th>订单序号</th>
                <th>城市</th>
                <th>产品</th>
                <th>用户下单时间</th>
                <th>服务开始时间</th>
                <th>价格</th>
                <th>用户实际支付价格</th>
                <th>服务地址</th>
                <th>电话</th>
                <th>用户备注</th>
                <th>客服备注</th>
                <th>订单状态</th>
                <th>操作</th>
            </tr>
            <?php
            error_reporting(1);
            $like = '\'%' . $_GET['w'] . '%\'';
            $data = $model->getList(['*'],"`cellphone` like $like or `orderId` like $like or `serviceTime` like $like or `serviceAddress` like $like or `houseNumber` like $like","$start,$num","orderId desc");
            foreach($data as $value)
            {
                $model2 = new Model('product');
                $product = $model2->getList(['productName'],'productId = '.$value['productId']);
                $value['productId'] = $product[0]['productName'];
                if($value['create_time'] != 0)
                    $date = gmdate('Y-m-d H:i:s',$value['create_time'] + 8*3600);
                else $date = "已丢失";
                echo
                "<tr>
                    <td>$value[orderId]</td>
                    <td>".$cityName[$value['cityId']]."</td>
                    <td>$value[productId]</td>
                    <td>$date</td>
                    <td>$value[serviceTime]</td>
                    <td>$value[price]</td>
                    <td>$value[settlePrice]</td>
                    <td>$value[serviceAddress]$value[houseNumber]</td>
                    <td>$value[cellphone]</td>
                    <td>$value[comment]</td>
                    <td>$value[custom_comment]</td>
                    <td>".$orderStatusName[$value['status']]."</td>
                    <td>
                    <a class='button' href='updateOrderStatus.php?orderId=$value[orderId]'>更新订单状态</a>
                    <a class='button' href='updateOrderInfo.php?orderId=$value[orderId]'>更新订单信息</a>
                    <a class='button' href='partnerCancelOrder.php?orderId=$value[orderId]'>取消订单</a>
                    <a class='button' href='commentOrder.php?orderId=$value[orderId]'>添加备注</a>
                    </td>
                  </tr>
                ";
            }
            ?>
        </thead>
    </table>
    <?php
        $allNum = $model->getCount("`cellphone` like $like or `orderId` like $like or `serviceTime` like $like or `serviceAddress` like $like or `houseNumber` like $like".$_SESSION['additional_where']);
        $pages = $allNum % $num == 0 ? $allNum / $num:$allNum / $num + 1;
    ?>
    <div class="contain-fluid text-center">
        <nav>
            <ul class="pagination">
                <li <?php if($_GET['page'] == 1)echo 'class="disabled"';?>><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <?php
                for($i = 1;$i <= $pages ;$i++) {

                    if($i == $_GET['page'])echo
                    "<li class='active' ><a href = '#' > $i <span class='sr-only' > (current)</span ></a ></li >";
                    else echo "<li ><a href = 'searchList.php?page=$i&num=$num&w=$_GET[w]' > $i <span class='sr-only' > $i</span ></a ></li >";
                }
                ?>
                <li <?php if($_GET['page'] == (int)$pages)echo 'class="disabled"';?>><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>
        </nav>
    </div>
</div>
<?php
echo file_get_contents('footer.html');
?>
