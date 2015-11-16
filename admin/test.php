<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-10
 * Time: 下午4:08
 */
if(isset($_POST['id'])){echo 'id';exit;}
require_once('httpPost.php');
echo httpPost('http://dianping.mifengbangmang.com/admin/test.php',['id'=>1]);