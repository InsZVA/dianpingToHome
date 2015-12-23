<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午8:38
 */

/**
 * @param $param
 * @param string $appKey
 * @return string
 */
$online_mode = true;
function getSign($param,$appKey = '760A479C0CF59B42F3B0AA2785FB9C6D')
{
    ksort($param);  //第一步，将所有请求的数据按字段名进行字段升序排序。
    $str = "";
    foreach($param as $key => $value)
        if($key != 'sign')$str .= $key . $value; //第二步，将【字段名】和【值】（url编码前的）按照第一步的顺序进行拼接,得到字符串
    $str .= $appKey;//第三步，将【点评】提供的appKey，比如ABCDEFGHIJKLMNOPQRSTUVWXYZ123456，拼接在第二步中获得的字符串后面得到字符串:
    $sign = md5($str);//第四步，将该字符串进行MD5计算结果为e15d48ce15536ca94c7e55d5e8963d99
    return strtoupper($sign);//第五步，将第四步得到的字符串全部upperCase，得到E15D48CE15536CA94C7E55D5E8963D99，这就是最后得到的签名。
}
