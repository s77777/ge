<?php

if (php_sapi_name()!=='cli') exit ();
error_reporting(E_ALL);ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);

$_GET['_url']=$argv[1];
$_SERVER['HTTP_ACCEPT_LANGUAGE']='en-en';
$_SERVER['REQUEST_SCHEME']='http';
$_SERVER['SERVER_NAME']='ge.local';
define('APP_PATH', realpath('..') . '/app/');
define('APP_PATH_CONF', APP_PATH . 'Config/');
$config=require_once APP_PATH_CONF . 'config.php';
define('APP_PATH_CLASSES', APP_PATH . $config['Classes']);
define('APP_PATH_VIEWS', APP_PATH . $config['Views']);
define('APP_PATH_LOCALE', APP_PATH . $config['Locale']);
define('APP_PATH_DATA', APP_PATH . $config['DataFilePath']);
define('APP_LOGS', APP_PATH . $config['Logs']);
require_once APP_PATH_CONF . 'autoloader.php';
try
{
    $p = new Page($config);
    define('LANG', 'en');
    $p->getContent();
}
catch (\Exception $e)
{
    Logs($e->getMessage()."\t".'Line: '.$e->getLine()."\t".$e->getFile());
}
