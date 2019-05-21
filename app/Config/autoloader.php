<?php

spl_autoload_register(function($classes){
    $filename = $classes . '.php';
    $file = APP_PATH_CLASSES . $filename;
    if (false == file_exists($file)) {
        header('Location:'.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.LANG.'/Index/error');
    }
    require ($file);
});

/**
* @return string
*/
function getLang() {
    $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $lang = explode(',',$lang);
    $lang = explode('-',$lang[0]);
    if (file_exists(APP_PATH_LOCALE.$lang[0]))
       return $lang[0];
    else
        return 'en';
}

/**
* @param string $data
*/
function Logs($data)
{
    $f = fopen(APP_LOGS .'Error.log', 'a');
    fputs($f, date('Y-m-d H:i:s')."\t".$_SERVER['DOCUMENT_URI']."\t".$data."\n");
    fclose($f);
}