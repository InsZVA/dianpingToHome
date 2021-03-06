<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-5
 * Time: 下午5:06
 */
require_once('access.php');
require_once('model/Model.php');
$model = new Model('technician');
if(isset($_POST['name']))
{
    if($_FILES['photo']['size'] < 1000000)
    {
        if($_FILES['photo']['error'] > 0)
        {
            echo "<script>alert('图片上传错误!');</script>";
        }
        else
        {
            $path = "upload/" . time() . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'],$path);
            unset($_POST['photo']);
            $_POST['photoURL'] = "http://dianping.mifengbangmang.com/admin/" . $path;
            $_POST['tags'] = json_encode(explode(",",$_POST['tags']));
            $_POST['productIds'] = json_encode($_POST['productIds']);
            $id = $_POST['technicianId'];
            unset($_POST['technicianId']);
            $model->edit('technicianId = '.$id,$_POST);
            echo "<script>alert('编辑成功!');</script>";
        }

    }
    else
        echo "<script>alert('图片大于1M!');</script>";

    echo "<script>window.location.replace('masterList.php');</script>";
    exit(0);
}
echo file_get_contents('header.html');
$model = new Model('technician');
$data = $model->getList(['*'],'technicianId = ' . $_GET['technicianId']);
$data = $data[0];
?>
<div class="row">
<div class="col-md-6">
    <form action="editMaster.php" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="form-group">
                <label for="name">技师姓名</label>
                <input name="technicianId"  type="hidden" id="technicianId" value="<?php echo $data['technicianId'];?>">
                <input name="name" id="name" placeholder="张三" class="form-control" value="<?php echo $data['name'];?>">
            </div>
            <div class="form-group">
                <label for="cityId">点评城市</label>
                <select name="cityId" id="cityId" class="form-controll">
                    <?php
                    require_once('cityId.php');
                    for($i = 1;$i < count($cityName);$i++)
                        if($data['cityId'] == $i)echo "<option value='$i' selected='selected'>$cityName[$i]</option>";
                        else echo "<option value='$i'>$cityName[$i]</option>"
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sex">技师性别</label>
                <select name="sex" id="sex" class="form-control">
                    <option value="男" <?php if($data['sex'] == "男")echo "checked";?>>男</option>
                    <option value="女" <?php if($data['sex'] == "女")echo "checked";?>>女</option>
                </select>
            </div>
            <div class="form-group">
                <img src="<?php echo $data['photoURL'];?>">
                <label for="photo">技师头像</label>
                <input type="file" name="photo" id="photo" class="" accept="image/*">
            </div>
            <div class="form-group">
                <label for="age">年龄</label>
                <input name="age" id="age" placeholder="30" class="form-control" value="<?php echo $data['age'];?>">
            </div>
            <div class="form-group">
                <label for="workingAge">工作年限</label>
                <input name="workingAge" id="workingAge" placeholder="10" class="form-control" value="<?php echo $data['workingAge'];?>">
            </div>
            <div class="form-group">
                <label for="orderAmount">接单数量（初始）</label>
                <input name="orderAmount" id="orderAmount" placeholder="40" class="form-control" value="<?php echo $data['orderAmount'];?>">
            </div>
            <div class="form-group">
                <label for="level">师傅星级</label>
                <input name="level" id="level" placeholder="5" class="form-control" value="<?php echo $data['level'];?>">
            </div>
            <div class="form-group">
                <label for="longitude">经度</label>
                <input name="longitude" id="longitude" placeholder="31.215377" class="form-control" value="<?php echo $data['longitude'];?>">
            </div>
            <div class="form-group">
                <label for="latitude">纬度</label>
                <input name="latitude" id="latitude" placeholder="121.80823" class="form-control" value="<?php echo $data['latitude'];?>">
            </div>
            <div class="form-group">
                <label for="phone">电话</label>
                <input name="phone" id="phone" placeholder="13800000000" class="form-control" value="<?php echo $data['phone'];?>">
            </div>
            <div class="form-group">
                <label for="description">描述</label>
                <input name="description" id="description" placeholder="明星师傅" class="form-control" value="<?php
                echo $data['description'];
                ?>">
            </div>
            <div class="form-group">
                <label for="tags">标签</label>
                <input name="tags" id="tags" placeholder="请用英文逗号分割多个标签：萌萌的,强大的" class="form-control" value="<?php
                $temp = 0;
                foreach(json_decode($data['tags'],true) as $value)
                {if($temp) echo ",";echo $value;$temp++;}
                ?>">
            </div>
            <div class="form-group">
                <label for="productIds">服务产品(按Shift和Ctrl多选)</label>
                <select name="productIds[]" id="productIds" class="form-control" multiple="multiple">
                    <?php
                    $model2 = new Model('product');
                    $data2 = $model2->getList(['productId','productName']);
                    $i = 0;
                    foreach($data2 as $value)
                    {
                        if(strpos($data['productIds'],$i)>=0)echo "<option value='$value[productId]' selected='selected'> $value[productName]</option>";
                        else echo "<option value='$value[productId]'>$value[productName]</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">编辑技师</button>
            </div>
        </div>
    </form>
</div>
</div>
<?php
    echo file_get_contents('footer.html');
?>