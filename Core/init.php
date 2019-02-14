<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-12
 * Time: 11:36 PM
 */
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'passsword' => '',
        'db' => 'laBd'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user'
    ),

);
spl_autoload_register(function($class)
{
    require_once 'Classes/' . $class . 'php';
});

require_once 'function/sanitize.php';