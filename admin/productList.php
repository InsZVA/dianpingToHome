<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午10:07
 */
require_once('access.php');
require_once('model/Model.php');
$model = new Model('product');
echo file_get_contents('header.html');
if(!isset($_GET['num']) || $_GET['num'] == '')
    $num = 10;
else
    $num = $_GET['num'];
if(!isset($_GET['page']) || $_GET['page'] == '')
    $_GET['page'] = 1;
$start = ($_GET['page']-1) * $num;

?>
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
                <th>产品序号</th>
                <th>产品名称</th>
                <th>产品描述</th>
                <th>原价格</th>
                <th>现价</th>
                <th>预览图</th>
                <th>操作</th>
            </tr>
            <?php
            $data = $model->getList(['productId','productName','description','originalPrice','settlePrice','thumbUrl'],'',"$start,$num");
            foreach($data as $value)
            {
                echo
                "<tr>
                    <td>$value[productId]</td>
                    <td>$value[productName]</td>
                    <td>$value[description]</td>
                    <td>$value[originalPrice]</td>
                    <td>$value[settlePrice]</td>
                    <td><img src='$value[thumbUrl]' style='width:120px'></td>
                    <td><a href='deleteProduct.php?productId=$value[productId]'>删除</a>
                    <a href='editProduct.php?productId=$value[productId]'>查看/编辑</a></td>
                  </tr>
                ";
            }
            ?>
        </thead>
    </table>
    <?php
        $allNum = $model->getCount();
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
                    else echo "<li ><a href = 'productList.php?page=$i&num=$num' > $i <span class='sr-only' > $i</span ></a ></li >";
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
