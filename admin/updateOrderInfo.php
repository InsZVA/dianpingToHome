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
    foreach($_POST as $key => $value)
    {
        if($value == '')unset($_POST[$key]);
    }
    $_POST['sign'] = getSign($_POST);;
    httpPost('http://m.api.dianping.com/tohome/openapi/exiugezi/',$_POST);
    updateOrder($_POST['orderId']);
    echo "<script>window.location.replace('orderList.php');</script>";
    exit(0);
}
echo file_get_contents('header.html');
?>
<div class="row">
    <div class="col-md-6">
        <div class="container-fluid">
            <form action="updateOrderInfo.php" method="post">
                <div class="form-group">
                    <input type="hidden" name="methodName" value="updateOrderInfo">
                    <label for="orderId">订单序号</label>
                    <input name="orderId" value="<?php echo $_GET['orderId'];?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="technicianId">指派师傅(可选,可留空)</label>
                    <input name="technicianId" placeholder="输入师傅ID" class="form-control">
                </div>
                <div class="form-group">
                    <label for="serviceTime">指派服务时间(可选)</label>
                    <input name="serviceTime" placeholder="输入格式:2015-08-07 12:00:00" class="form-control">
                </div>
                <div class="form-group">
                    <label for="serviceAddress">指派服务地址(可选)</label>
                    <input name="serviceAddress" placeholder="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="houseNumber">指派详细地址(可选)</label>
                    <input name="houseNumber" placeholder="" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="提交">
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo file_get_contents('footer.html');?>