<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 00:28
 */
require_once '../core/init.php';
header('Content-Type: application/json');

if (isset($_GET))
{
    $data  = new SupplierUsersList($_GET['idSupplier']);

    echo $data->data();

}