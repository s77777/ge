<?php

if ($_SERVER['SERVER_NAME']=='ge.local')
{
    error_reporting(E_ALL);ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
}
else
{
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_PARSE);ini_set('display_errors', FALSE);ini_set('display_startup_errors', FALSE);
}
define('APP_PATH', realpath('..') . '/app/');
define('APP_PATH_CONF', APP_PATH . 'Config/');
$config=require_once APP_PATH_CONF . 'config.php';
define('APP_PATH_CLASSES', APP_PATH . $config['Classes']);
define('APP_PATH_VIEWS', APP_PATH . $config['Views']);
define('APP_PATH_LOCALE', APP_PATH . $config['Locale']);
define('APP_PATH_DATA', APP_PATH . $config['DataFilePath']);
define('APP_LOGS', APP_PATH . $config['Logs']);
define('SERVER_NAME', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']);
require_once APP_PATH_CONF . 'autoloader.php';

try
{
    $p = new Page($config);
    if ($p->getLangArg()=='') {
        header('Location:'.SERVER_NAME.'/'.getLang());
    }
    define('LANG', $p->getLangArg());
    $p->getContent();
}
catch (\Exception $e)
{
    Logs($e->getMessage()."\t".'Line: '.$e->getLine()."\t".$e->getFile());
}
