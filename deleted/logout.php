<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 2:57 PM
 */
require_once './../core/init.php';

$user = new oauth_users();
$user->logout();

Redirect::to('index.php');