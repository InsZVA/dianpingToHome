<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-5
 * Time: 下午5:06
 */
require_once('access.php');
require_once('model/Model.php');
$model = new Model('product');
if(isset($_POST['productName']))
{
    //var_dump($_POST);
    if($model->insert($_POST,true) > 0)echo "<script>alert('添加成功!');</script>";
    echo "<script>window.location.replace('productList.php');</script>";
    exit(0);
}
echo file_get_contents('header.html');
?>
<script>
    var details = [];
    var imageUrls = [];
</script>
<div class="row">
<div class="col-md-6">
    <form action="addProduct.php" method="post">
        <div class="container-fluid">
            <div class="form-group">
                <label for="productName">产品名称</label>
                <input name="productName" id="productName" placeholder="修马桶" class="form-control">
            </div>
            <div class="form-group">
                <label for="orderAmount">近期销量(初始)</label>
                <input name="orderAmount" id="orderAmount" placeholder="100" class="form-control">
            </div>
            <div class="form-group">
                <label for="duration">服务耗时(分钟)</label>
                <input name="duration" id="duration" placeholder="120" class="form-control">
            </div>
            <div class="form-group">
                <label for="abstract">摘要(显示在产品列表)</label>
                <input name="abstract" id="abstract" placeholder="专业修马桶1000年" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">描述</label>
                <input name="description" id="description" placeholder="专业修马桶1000年" class="form-control">
            </div>
            <div class="form-group">
                <label for="latitude">图文详情</label>
                <div id="detailsView" class=""></div>
                <input name="details" id="details" placeholder="json数据,请勿修改!" class="form-control" value="">
                <label for="uploadImage">添加图片</label>
                <input type="file" id="uploadImage">
                <button type="button" onclick="UploadFile()">添加图片</button><br/>
                <label for="uploadImage">添加文字</label>
                <input id="addText" class="form-control">
                <button type="button" onclick="AddText()">添加文字</button><br/>
                <button type="button" onclick="clearDetails()">清空详情</button>
            </div>
            <div class="form-group">
                <label for="originalPrice">原始价格(元)</label>
                <input name="originalPrice" id="originalPrice" placeholder="100" class="form-control">
            </div>
            <div class="form-group">
                <label for="settlePrice">真实价格(元)</label>
                <input name="settlePrice" id="settlePrice" placeholder="50" class="form-control">
            </div>
            <div class="form-group">
                <label for="minOrders">最小下单份数</label>
                <input name="minOrders" id="minOrders" placeholder="1" class="form-control">
            </div>
            <div class="form-group">
                <label for="maxOrders">最大下单份数</label>
                <input name="maxOrders" id="maxOrders" placeholder="1" class="form-control">
            </div>
            <div class="form-group">
                <label for="imageUrls">多张产品图</label>
                <div id="imagesView" class=""></div>
                <input name="imageUrls" id="imageUrls" placeholder="json数据,请勿修改!" class="form-control" value="">
                <label for="uploadImage2">添加图片(640*360)</label>
                <input type="file" id="uploadImage2">
                <button type="button" onclick="UploadImage()">添加图片</button><br/>
                <button type="button" onclick="clearImages()">清空图片</button>
            </div>
            <div class="form-group">
                <label for="thumbUrl">预览图</label>
                <div id="imagesView2" class=""></div>
                <input name="thumbUrl" id="thumbUrl" placeholder="json数据,请勿修改!" class="form-control" value="">
                <label for="uploadImage2">添加图片(640*640)</label>
                <input type="file" id="uploadImage3">
                <button type="button" onclick="UploadImage2()">上传图片</button>
            </div>
            <div class="form-group">
                <label for="rank">优先级(越小在大众点评越靠前)</label>
                <input name="rank" id="rank" placeholder="1" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit">添加产品</button>
            </div>

        </div>
    </form>
</div>
</div>
<?php
    echo file_get_contents('footer.html');
?>
<script>
    function UploadFile() {
        var fileObj = document.getElementById("uploadImage").files[0]; // 获取文件对象
        var FileController = "uploadFile.php";                    // 接收上传文件的后台地址
        // FormData 对象
        var form = new FormData();
        form.append("file", fileObj);                           // 文件对象
        // XMLHttpRequest 对象
        var xhr = new XMLHttpRequest();
        xhr.open("post", FileController, true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var json = eval("("+xhr.responseText+")");
                if(json.status == -1)
                    alert("文件大小超过限制!");
                else if(json.status > 0)
                    alert("文件上传错误:" + json.status + "!");
                else
                {
                    alert("添加成功!");
                    details.push({'type':1,'content':'http://dianping.mifengbangmang.com/admin/' + json.path});
                    var text = document.getElementById("detailsView");
                    text.innerHTML += '<img src="' + 'http://dianping.mifengbangmang.com/admin/' + json.path + '"><br/>';
                    var detailsDOM = document.getElementById("details");
                    detailsDOM.value = JSON.stringify(details);
                }
            }
        };
        xhr.send(form);
    }
    function AddText() {
        alert("添加成功!");
        var text = document.getElementById("addText");
        details.push({'type':2,'content':text.value});
        var deatilsView = document.getElementById("detailsView");
        deatilsView.innerHTML += '<p>' + text.value + '</p>';
        var detailsDOM = document.getElementById("details");
        detailsDOM.value = JSON.stringify(details);
        text.value = '';
    }
    function UploadImage() {
        var fileObj = document.getElementById("uploadImage2").files[0]; // 获取文件对象
        var FileController = "uploadFile.php";                    // 接收上传文件的后台地址
        // FormData 对象
        var form = new FormData();
        form.append("file", fileObj);                           // 文件对象
        // XMLHttpRequest 对象
        var xhr = new XMLHttpRequest();
        xhr.open("post", FileController, true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var json = eval("("+xhr.responseText+")");
                if(json.status == -1)
                    alert("文件大小超过限制!");
                else if(json.status > 0)
                    alert("文件上传错误:" + json.status + "!");
                else
                {
                    alert("添加成功!");
                    imageUrls.push('http://dianping.mifengbangmang.com/admin/' + json.path);
                    var text = document.getElementById("imagesView");
                    text.innerHTML += '<img src="' + 'http://dianping.mifengbangmang.com/admin/' + json.path + '"><br/>';
                    var imagesDOM = document.getElementById("imageUrls");
                    imagesDOM.value = JSON.stringify(imageUrls);
                }
            }
        };
        xhr.send(form);
    }
    function UploadImage2() {
        var fileObj = document.getElementById("uploadImage3").files[0]; // 获取文件对象
        var FileController = "uploadFile.php";                    // 接收上传文件的后台地址
        // FormData 对象
        var form = new FormData();
        form.append("file", fileObj);                           // 文件对象
        // XMLHttpRequest 对象
        var xhr = new XMLHttpRequest();
        xhr.open("post", FileController, true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var json = eval("("+xhr.responseText+")");
                if(json.status == -1)
                    alert("文件大小超过限制!");
                else if(json.status > 0)
                    alert("文件上传错误:" + json.status + "!");
                else
                {
                    alert("添加成功!");
                    var text = document.getElementById("imagesView2");
                    text.innerHTML = '<img src="' + 'http://dianping.mifengbangmang.com/admin/' + json.path + '"><br/>';
                    var imagesDOM = document.getElementById("thumbUrl");
                    imagesDOM.value = 'http://dianping.mifengbangmang.com/admin/' + json.path;
                }
            }
        };
        xhr.send(form);
    }
    function clearDetails()
    {
        details = [];
        var detailsView = document.getElementById('detailsView');
        detailsView.innerHTML = "";
        var detailsDOM = document.getElementById("details");
        detailsDOM.value = "";
    }
    function clearImages()
    {
        imageUrls = [];
        var imagesView = document.getElementById('imagesView');
        imagesView.innerHTML = "";
        var imagesDOM = document.getElementById("imageUrls");
        imagesDOM.value = "";
    }
</script>
