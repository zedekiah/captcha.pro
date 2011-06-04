<?php

function procaptcha_verify($hash, $word)
{
    $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";$ch=curl_init();
    $url = 'http://procaptcha/dev.php/captcha/verification/hash/'.$hash.'/word/'.$word;
    curl_setopt ($ch, CURLOPT_URL,$url );
    //curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch,CURLOPT_VERBOSE,false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $page=curl_exec($ch);
    //echo curl_error($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    //die(var_dump($httpcode));
    if($httpcode=200) return true;
    else return false;
}
