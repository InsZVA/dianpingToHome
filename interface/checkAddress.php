<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-26
 * Time: 下午3:44
 * @param $longitude
 * @param $latitude
 * @param $cityId
 * @return bool
 */
require_once('../admin/httpPost.php');
function checkAddress($longitude,$latitude,$cityId)
{
    $data = json_decode(file_get_contents("http://120.26.40.245:8888/?cityId=$cityId&latitude=$latitude&longitude=$longitude"),true);
    return $data['body'] == 'true';
}