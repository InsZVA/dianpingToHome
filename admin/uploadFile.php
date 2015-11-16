<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-5
 * Time: 下午7:54
 */
require_once('access.php');
if($_FILES['file']['size'] < 1000000)
{
    if($_FILES['file']['error'] > 0)
    {
        echo json_encode(['status'=>$_FILES['file']['error']]);
    }
    else
    {
        $path = "upload/" . time() . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],$path);
        echo json_encode(['status'=>'0','path'=>$path]);
    }
}
else
    echo json_encode(['status'=>'-1']);
?>