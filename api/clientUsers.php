<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 01:30
 */
require_once '../core/init.php';
header('Content-Type: application/json');

if (isset($_GET))
{
    $data  = new ClientUsers($_GET['idClient']);

    echo $data->data();

}