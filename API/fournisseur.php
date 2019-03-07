<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-02-18
 * Time: 8:58 PM
 */


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idSupplier = $_GET['idSupplier'];

    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];

    if($about == "client") {

        if(!empty($idAbout))
        {
            $res = new Supplier();
            echo $res->getClientList();
        }
        else
        {
            $res = new Client();
            echo $res->loadFromDB($idAbout);
        }

    } else if($page == "produit") {

        if(!empty($id))
            include('supplierProduits.php');

    } else if($page == "user") {

        if(!empty($id))
            include('supplierUsers.php');

    }else if($page == "commande") {

        if(!empty($id))
            include('supplierUsers.php');

    }

//fin de GET






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

