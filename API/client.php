<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 01:30
 */
require_once '../core/init.php';
header('Content-Type: application/json');

/*if (isset($_GET))
{
    $data  = new ClientUsers($_GET['idClient']);

    echo $data->data();

}*/


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
        $resutat = $res->getClientDetails();
        echo $resutat;

    } else if ($about == "produit") {

            /* obtenir la liste des produits du fournisseur rattaché au client */
        if (empty($idAbout)) {
            $resutat = $res->getProductsList();
            echo $resutat;

            //include('supplierProduits.php');
            //$res = new Supplier();
            //echo $res->getProductList();

            /* obtenir la description d'un produit */
        } else {
            $resutat = $res->getProductDetails($idAbout);
            echo $resutat;

            //$res = new Product();
            //echo $res->loadFromDB($idAbout);
        }

    } else if ($about == "user") {

            /* obtenir la liste des utilisateurs client */
        if (empty($idAbout)) {
            $resutat = $res->getUsersList();
            echo $resutat;

            //include('supplierUsers.php');
            //$res = new Client($idClient);
            //echo $res->getClientUsersList();

            /* obtenir la description d'un utilisateurs */
        } else {
            $resutat = $res->getUser($idAbout);
            echo $resutat;

            //$res = new User();
            //echo $res->loadFromDB($idAbout);
        }

    } else if ($about == "order") {

            /* obtenir la liste des commandes du fournisseur rattaché au client */
        if (empty($idAbout)) {
            $resutat = $res->getOrdersList();
            echo $resutat;

            //include('supplierUsers.php');
            //$res = new Client($idClient);
            //echo $res->getClientOrdersList();

            /* obtenir la description d'une commande */
        } else {
            $resutat = $res->getOrder($idAbout);
            echo $resutat;

            //$res = new Order();
            //echo $res->loadFromDB($idAbout);
        }
    }

/* POST : mettre info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idClient = $_POST['idClient'];

    $about = $_POST['about'];
    $idAbout = $_POST['idAbout'];

    $res = new Client($idClient);

    if($about == "product") {

            /* erreur si produit non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            $donnees = json_decode($url, true);     //associative array
            $res->addProduct($donnees);
            echo "Succès";

            //$res = new Product();
            //$res->addProduct($idAbout);
        }

    } else if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $url = file_get_contents("http://.../api/Client/".$idClient."/user/.".$idAbout);
            $donnees = json_decode($url, true);     //associative array
            $res->addUser($donnees);
            echo "Succès";
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $url = file_get_contents("http://.../api/Client/".$idClient."/user/.".$idAbout);
            $donnees = json_decode($url, true);     //associative array
            $res->addOrder($donnees);
            echo "Succès";

            //$res = new Order();
            //$res->addOrder($idAbout);
        }
    }

/* PUT : mettre à jour info dans la BD */

} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $idClient = $_PUT['idClient'];

    $about = $_PUT['about'];
    $idAbout = $_PUT['idAbout'];

    $res = new Client($idClient);

    if($about == "product") {

            /* erreur si produit non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            $donnees = json_decode($url, true);     //associative array
            $res->deleteProduct($idAbout);
            $res->addProduct($donnees);
            echo "Succès";

            //$res = new Product();
            //$res->updateProduct($idAbout);

        }

    } else if($about == "user") {

            /* erreur si utilisateur non spécifié */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            $donnees = json_decode($url, true);     //associative array
            $res->deleteUser($idAbout);
            $res->addUser($donnees);
            echo "Succès";

            //$res = new User();
            //echo $res->updateUser($idAbout);
        }

    }else if($about == "order") {

            /* erreur si commande non spécifiée */
        if(empty($idAbout)) {
            echo "Erreur";

        } else {
            $url = file_get_contents("http://.../api/Client/".$idClient."/product/.".$idAbout);
            $donnees = json_decode($url, true);     //associative array
            $res->deleteOrder($idAbout);
            $res->addOrder($donnees);
            echo "Succès";

            //$res = new Order();
            //$res->updateOrder($idAbout);
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

            //$res = new Supplier();
            //echo $res->deleteAllProducts();

        } else {
            $res->deleteProduct($idAbout);
            echo "Succès";

            //$res = new Product();
            //echo $res->deleteProduct($idAbout);
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            $res->deleteAllUsers();
            echo "Succès";

            //$res = new Client($idClient);
            //echo $res->deleteAllUsers();

        } else {
            $res->deleteUser($idAbout);
            echo "Succès";

            //$res = new User();
            //echo $res->deleteUser($idAbout);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            $res->deleteAllOrders();
            echo "Succès";

            //$res = new Client($idClient);
            //echo $res->deleteAllOrders();

        } else {
            $res->deleteOrder($idAbout);
            echo "Succès";

            //$res = new Order();
            //$res->deleteOrder($idAbout);
        }
    }
}
