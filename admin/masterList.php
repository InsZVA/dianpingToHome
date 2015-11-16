<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午10:07
 */
require_once('access.php');
require_once('model/Model.php');
$model = new Model('technician');
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
                <th>师傅序号</th>
                <th>姓名</th>
                <th>城市</th>
                <th>电话</th>
                <th>描述</th>
                <th>操作</th>
            </tr>
            <?php
            $data = $model->getList(['technician.technicianId','technician.name','technician.cityId','technician.phone','technician.description'],'',"$start,$num");
            foreach($data as $value)
            {
                echo
                "<tr>
                    <td>$value[technicianId]</td>
                    <td>$value[name]</td>
                    <td>$value[cityId]</td>
                    <td>$value[phone]</td>
                    <td>$value[description]</td>
                    <td><a href='deleteMaster.php?technicianId=$value[technicianId]'>删除</a>
                    <a href='editMaster.php?technicianId=$value[technicianId]'>查看/编辑</a></td>
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
                    else echo "<li ><a href = 'masterList.php?page=$i&num=$num' > $i <span class='sr-only' > $i</span ></a ></li >";
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
