<?php

function str_randoms($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/* convert date string to date, $format can be leave as blank  */
function date_norm($date = '0000-00-00', $format = 'Y-m-d')
{
	return date($format, strtotime($date));
}

/* modify by adding or substracting date, default -1 day */
function date_alter($date_raw, $alter = '-1 day')
{
	return date('Y-m-d', strtotime($alter, strtotime($date_raw)));
}

/* return a <strong> string */
function _strong($str)
{
	return '<strong>'.$str.'</strong>';
}

/* return a clean string for slug purposes */
function slug($str)
{
	return str_replace(" ","-",strtolower($str));
}