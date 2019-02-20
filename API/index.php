<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-02-18
 * Time: 8:58 PM
 */

include('../Classes/SupplierClientsList.php');
include('../Classes/SupplierProduitsList.php');
include('../Classes/SupplierUsersList.php');
include('../Classes/ClientUsersList.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $page = $_GET['page'];
    $id = $_GET['idSupplier'];

    if($page == "client") {

        if(!empty($id))
            include('supplierClients.php');

    } else if($page == "produit") {

        if(!empty($id))
            include('supplierProduits.php');

    } else if($page == "user") {

        if(!empty($id))
            include('supplierUsers.php');

    }


} else  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = $_POST['page'];

    if($page == "client") {

        if(!empty($id))
            include('createClient.php');

    } else if($page == "user") {

        if(!empty($id))
            include('createUser.php');

    }


}

