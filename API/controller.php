<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-03-17
 * Time: 8:53 PM
 */


$sizeUrl = sizeof($url);
$url = explode('/', $_GET['url']);

$_GET['idSupplier']     = "";
$_GET['idClient']       = "";
$_GET['idProduit']      = "";
$_GET['idAdmin']        = "";
$_GET['about']          = "";
$_GET['idAbout']        = "";

if($sizeUrl > 5) {
    // envoier une reponse http avec l'erreur 400 et un message d'erreur
    header(trim("HTTP/1.0 404 Page Not Found"));
}


for($i = 0; $i < $sizeUrl; $i++) {

    if($i == 0) {
        redirect("http://gestiondecommandes.langoni.ca");
    } else if($i == 1) {

        if (strcasecmp($url[$i], "supplier") == 0) {
            $_GET['idSupplier'] = $url[$i];
            include('supplier.php');
        } elseif (strcasecmp($url[$i], "client") == 0) {
            $_GET['idClient'] = $url[$i];
            include('client.php');
        } elseif (strcasecmp($url[$i], "product") == 0) {
            $_GET['idProduit'] = $url[$i];
            include('produits.php');
        } elseif (strcasecmp($url[$i], "admin") == 0) {
            $_GET['idAdmin'] = $url[$i];
            include('admin.php');
        }
    } else if($i == 3) {
        $_GET['about'] = $url[$i];
    } else if($i == 4) {
        $_GET['idAbout'] = $url[$i];
    }

}

// Si la requete est faite en methode GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

}

// Si la requete est faite en methode POST
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}