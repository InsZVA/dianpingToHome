<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-6
 * Time: 下午2:08
 */
require_once('access.php');
require_once('model/Model.php');
$model = new Model('payment');
if(isset($_POST['orderId']))
{
    $model->edit("payment.orderId = $_POST[orderId]",['custom_comment' => $_POST['custom_comment']]);
    echo "<script>window.location.replace('orderList.php');</script>";
    exit(0);
}
echo file_get_contents('header.html');
$data = $model->getList(['custom_comment'],"payment.orderId = $_GET[orderId]");
$data = $data[0];
?>
<div class="row">
    <div class="col-md-6">
        <div class="container-fluid">
            <form action="commentOrder.php" method="post">
                <div class="form-group">
                    <label for="orderId">订单序号</label>
                    <input name="orderId" value="<?php echo $_GET['orderId'];?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="custom_comment">备注</label>
                    <input name="custom_comment" placeholder="输入备注" class="form-control" value="<?php echo $data['custom_comment'];?>">
                </div>
                <div class="form-group">
                    <input type="submit" value="提交">
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo file_get_contents('footer.html');?>