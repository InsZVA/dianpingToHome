<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-6
 * Time: 下午2:08
 */
require_once('access.php');
if(isset($_GET['productId']))
{
    require_once('model/Model.php');
    $model = new Model('product');
    if($model->remove("productId = $_GET[productId]"))echo "<script>alert('删除成功!');</script>";
    else "<script>alert('删除失败!');</script>";

}
echo "<script>window.location.replace('productList.php');</script>";