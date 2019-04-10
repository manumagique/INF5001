<?php

/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 01:30
 */
require_once '../core/init.php';
header('Content-Type: application/json');

$username =  $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];
$user = new oauth_users();
$login = $user->login($username, $pass);
if ($login)
{
    echo "votre jetons est :prout prout prout";
//    Redirect::to('index.php');
}
else
{
    echo 'désolé, la connection a échoué';
}