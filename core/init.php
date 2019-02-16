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
        'host' => '69.28.199.20',
        'user' => 'lango721_inm5001',
        'passsword' => '?h17b+gplF;H',
        'db' => 'lango721_gestiondecommandes'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),

);
spl_autoload_register(function($class)
{
    require_once 'Classes/' . $class . '.php';
});

require_once 'Functions/sanitize.php';