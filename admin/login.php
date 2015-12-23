<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-12
 * Time: 下午3:01
 */
session_start();
unset($_SESSION['admin']);
unset($_SESSION['additional_where']);
?>

    <form action="valid.php" method="post">
        <p>选择您管理的城市(Shift Ctrl 多选):</p>
        <select name="cityId[]" multiple="multiple" style="height:300px;width:60px">
            <?php $cityName=[0=>'','上海','北京','杭州','广州','南京','苏州','深圳','成都','重庆','天津','宁波','扬州','无锡','福州','厦门','武汉','西安','沈阳','大连','青岛','济南','海口','石家庄'];
                $accept = [1,3,2,4,7,9,8,16,17,5,11,10,21];
                foreach($accept as $v)
                {
                    echo "<option value=$v>" . $cityName[$v] . "</option>";
                }
            ?>
        </select>
        <br/>
        <input name="password" placeholder="请输入登陆口令" type="password">
        <input type="hidden" name="redirect" value="<?php echo 'http://dianping.mifengbangmang.com/admin/orderList.php';?>">

        <input type="submit">
    </form>
