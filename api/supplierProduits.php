<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-18
 * Time: 23:09
 */
require_once '../core/init.php';
header('Content-Type: application/json');

if (isset($_GET))
{
    $data  = new SupplierProduitsList($_GET['idSupplier']);

    echo $data->data();

}