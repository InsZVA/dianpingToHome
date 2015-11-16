<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-6
 * Time: 下午2:18
 * @param $uri
 * @param $data
 * @param bool $debug
 * @return mixed
 */
function httpPost($uri,$data,$debug = true)
{
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $uri );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    $result = curl_exec ( $ch );
    curl_close ( $ch );
    if($debug)
    {
        echo "curl -d \"" . http_build_query($data) . "\" $uri<br/>";
    }
    return $result;
}