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

    $idClient = $_POST['idClient'];
    $about = $_POST['about'];
    $idAbout = $_POST['idAbout'];
    $res = new Client($idClient);
    $data = json_decode(file_get_contents("php://input"));

    if($about == "product") {

            /* erreur si produit non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";
        } else {
            //$url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            //$donnees = json_decode($url, true);     //associative array
            $res->addProduct($data);
            echo "Succès";
        }

    } else if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";
        } else {
            //$url = file_get_contents("http://.../api/Client/".$idClient."/user/.".$idAbout);
            //$donnees = json_decode($url, true);     //associative array
            $res->addUser($data);
            echo "Succès";
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";
        } else {
            //$url = file_get_contents("http://.../api/Client/".$idClient."/user/.".$idAbout);
            //$donnees = json_decode($url, true);     //associative array
            $res->addOrder($data);
            echo "Succès";
        }
    }

/* PUT : mettre à jour info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $idClient = $_PUT['idClient'];
    $about = $_PUT['about'];
    $idAbout = $_PUT['idAbout'];
    $res = new Client($idClient);
    $data = json_decode(file_get_contents("php://input"));

    if($about == "product") {

            /* erreur si produit non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";
        } else {
            //$url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            //$donnees = json_decode($url, true);     //associative array
            $res->updateProduct($data, $idAbout);
            echo "Succès";
        }

    } else if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";
        } else {
            //$url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            //$donnees = json_decode($url, true);     //associative array
            $res->updateUser($data, $idAbout);
            echo "Succès";
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";
        } else {
            //$url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            //$donnees = json_decode($url, true);     //associative array
            $res->updateOrder($data, $idAbout);
            echo "Succès";
        }
    }

/* DELETE : supprimer info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $idClient = $_DELETE['idClient'];
    $about = $_DELETE['about'];
    $idAbout = $_DELETE['idAbout'];
    $res = new Client($idClient);

    if($about == "product") {

        if(empty($idAbout)) {
            $res->deleteAllProducts();
            echo "Succès";
        } else {
            $res->deleteProduct($idAbout);
            echo "Succès";
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            $res->deleteAllUsers();
            echo "Succès";
        } else {
            $res->deleteUser($idAbout);
            echo "Succès";
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            $res->deleteAllOrders();
            echo "Succès";
        } else {
            $res->deleteOrder($idAbout);
            echo "Succès";
        }
    }
}
