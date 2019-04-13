<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 01:30
 */
require_once '../core/init.php';
header('Content-Type: application/json');

/**
 * Author: Valentina
 * Date: Winter 2019
 */


/* GET : obtenir info de la BD */

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idClient = $_GET['idClient'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Client($idClient);

    if (empty($about)) {
        echo $res->getClientDetails();

    } else if ($about == "product") {

            /* obtenir la liste des produits du fournisseur rattaché au client */
        if (empty($idAbout)) {
            echo $res->getProductsList();

            /* obtenir la description d'un produit */
        } else {
            echo $res->getProductDetails($idAbout);
        }

    } else if ($about == "user") {

            /* obtenir la liste des utilisateurs client */
        if (empty($idAbout)) {
            echo $res->getUsersList();

            /* obtenir la description d'un utilisateurs */
        } else {
            echo $res->getUser($idAbout);
        }

    } else if ($about == "order") {

            /* obtenir la liste des commandes du fournisseur rattaché au client */
        if (empty($idAbout)) {
            echo $res->getOrdersList();

            /* obtenir la description d'une commande */
        } else {
            echo $res->getOrder($idAbout);
        }
    }

/* POST : mettre info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idClient = $_GET['idClient'];
    $about = $_GET['about'];
    //$idAbout = $_GET['idAbout'];
    $res = new Client($idClient);
    $data = json_decode(file_get_contents("php://input"));

    if($about == "user") {
        $res->addUser($data);

    } else if($about == "order") {
        $res->addOrder($data);
    }

/* PUT : mettre à jour info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $idClient = $_GET['idClient'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Client($idClient);
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res->updateUser($data, $idAbout);
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $res->updateOrder($data, $idAbout);
        }
    }

/* DELETE : supprimer info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $idClient = $_GET['idClient'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Client($idClient);

    if($about == "product") {

        if(empty($idAbout)) {
            $res->deleteAllProducts();

        } else {
            $res->deleteProduct($idAbout);

        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            $res->deleteAllUsers();

        } else {
            $res->deleteUser($idAbout);

        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            $res->deleteAllOrders();

        } else {
            $res->deleteOrder($idAbout);

        }
    }
}
