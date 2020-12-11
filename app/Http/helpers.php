<?php

function get_string_bettween_string($startTag, $endTag, $text)
{
    $delimiter = '#';
    $regex = $delimiter . preg_quote($startTag, $delimiter) . '(.*?)' . preg_quote($endTag, $delimiter) . $delimiter . 's';
    preg_match($regex, $text, $matches);

    return $matches;
}
function getToken($length, $char = false)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if(!$char){

        $codeAlphabet.= "0123456789";
    }
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
