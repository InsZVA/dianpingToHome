<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-12
 * Time: 下午3:01
 */
session_start();
if(!isset($_SESSION['admin']))
{
    ?>
    <form action="valid.php" method="post">
        <input name="password" placeholder="请输入登陆口令" type="password">
        <input type="hidden" name="redirect" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
        <input type="submit">
    </form>
<?php
    exit;
}