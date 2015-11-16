<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-6
 * Time: 下午2:08
 */
require_once('access.php');
if(isset($_POST['methodName']))
{
    require_once('../interface/sign.php');
    require_once('httpPost.php');
    require_once('loadOrderInfo.php');
    $_POST['sign'] = getSign($_POST);
    httpPost('http://m.api.dianping.com/tohome/openapi/exiugezi/',$_POST);
    updateOrder($_POST['orderId'],false);
    echo "<script>window.location.replace('orderList.php');</script>";
    exit(0);
}
echo file_get_contents('header.html');
?>
<div class="row">
    <div class="col-md-6">
        <div class="container-fluid">
            <form action="updateOrderStatus.php" method="post">
                <div class="form-group">
                    <input type="hidden" name="methodName" value="updateOrderStatus">
                    <label for="orderId">订单序号</label>
                    <input name="orderId" value="<?php echo $_GET['orderId'];?>" class="form-control">
                    <label for="status">状态</label>
                    <select name="status" class="form-control">
                        <option value="13">确认订单</option>
                        <option value="3">技师出发</option>
                        <option value="4">服务中</option>
                        <option value="5">服务已完成</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="提交">
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo file_get_contents('footer.html');?>