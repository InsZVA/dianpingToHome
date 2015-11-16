<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-4
 * Time: 下午5:01
 */
require_once('sign.php');
if(getSign($_POST) == $_POST['sign'])
    echo json_encode(['code'=>'10001']);