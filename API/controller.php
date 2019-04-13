<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-03-17
 * Time: 8:53 PM
 */



#echo '<hr/>';
#echo $_GET['url'] . "<br>";
header('Access-Control-Allow-Origin: *');
$url = explode('/', $_GET['url']);
$sizeUrl = sizeof($url);


$_GET['idSupplier']     = "";
$_GET['idClient']       = "";
$_GET['idProduit']      = "";
$_GET['idAdmin']        = "";
$_GET['about']          = "";
$_GET['idAbout']        = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (strcasecmp($url[1], "supplier") == 0) {
        $_GET['idSupplier'] = $url[2];
        $_GET['about'] = $url[3];
        $_GET['idAbout'] = $url[4];
        include('supplier.php');
    } elseif (strcasecmp($url[1], "client") == 0) {
        $_GET['idClient'] = $url[2];
        $_GET['about'] = $url[3];
        $_GET['idAbout'] = $url[4];
        include('client.php');
    } elseif (strcasecmp($url[1], "product") == 0) {
        $_GET['idProduit'] = $url[2];
        $_GET['about'] = $url[3];
        $_GET['idAbout'] = $url[4];
        include('produits.php');
    } elseif (strcasecmp($url[1], "admin") == 0) {
        $_GET['idAdmin'] = $url[2];
        $_GET['about'] = $url[3];
        $_GET['idAbout'] = $url[4];
        include('admin.php');
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

   echo "";
}

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}


