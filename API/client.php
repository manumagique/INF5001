<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 01:30
 */
/**
 * Author: Valentina
 * Date: Winter 2019
 */
require_once '../core/init.php';
header('Content-Type: application/json');

/* GET : obtenir info de la BD */

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idClient = $_GET['idClient'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];

    $client = new Client($idClient);
    if ($about == "produit") {

            /* obtenir la liste des produits du fournisseur rattaché au client */
        if (empty($idAbout)) {
            //include('supplierProduits.php');
            $supplier = new Supplier($client->getClientSupplier());
            echo $supplier->getProductList();

            /* obtenir la description d'un produit */
        } else {
            $res = new Product($idAbout);
            echo $res->toJSON();
        }

    } else if ($about == "user") {

            /* obtenir la liste des utilisateurs client */
        if (empty($idAbout)) {
            echo $client->getClientUsersList();

            /* obtenir la description d'un utilisateurs */
        } else {
            $user = new User();
            echo $user->loadFromDB($idAbout);
        }

    } else if ($about == "order") {

            /* obtenir la liste des commandes du fournisseur rattaché au client */
        if (empty($idAbout)) {
            //include('supplierUsers.php');
            echo $client->getClientOrdersList();

            /* obtenir la description d'une commande */
        } else {
            $res = new Order($idAbout);
            echo $res->loadFromDB($idAbout);
        }
    }

/* POST : mettre info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idClient = $_POST['idClient'];

    $about = $_POST['about'];
    $idAbout = $_POST['idAbout'];

    if($about == "product") {

            /* erreur si produit non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res = new Product();
            $res->addProduct($idAbout);
        }

    } else if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            include('createClient.php');
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res = new Order();
            $res->addOrder($idAbout);
        }
    }

/* PUT : mettre à jour info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $idClient = $_PUT['idClient'];

    $about = $_PUT['about'];
    $idAbout = $_PUT['idAbout'];

    if($about == "product") {

            /* erreur si produit non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res = new Product();
            $res->updateProduct($idAbout);
        }

    } else if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res = new User();
            echo $res->updateUser($idAbout);
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res = new Order();
            $res->updateOrder($idAbout);
        }
    }

/* DELETE : supprimer info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $idClient = $_DELETE['idClient'];

    $about = $_DELETE['about'];
    $idAbout = $_DELETE['idAbout'];

    if($about == "product") {

        if(empty($idAbout)) {
            $res = new Supplier();
            echo $res->deleteAllProducts();

        } else {
            $res = new Product();
            echo $res->deleteProduct($idAbout);
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            $res = new Client($idClient);
            echo $res->deleteAllUsers();

        } else {
            $res = new User();
            echo $res->deleteUser($idAbout);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            $res = new Client($idClient);
            echo $res->deleteAllOrders();

        } else {
            $res = new Order();
            $res->deleteOrder($idAbout);
        }
    }
}
