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

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $validation = new Validation();


    if (strcasecmp($url[1], "client") == 0) {

        $name       = $validation->isValidName($data->name);
        $company    = $validation->isValidTextField($data->compagny, "Company");
        $email      = $validation->isValidEmail($data->email);
        $buyCond    = $validation->isValidBuyCondition($data->buy_condition);
        $recAdress  = $validation->isValidRecipientAddress($data->rec_adress);
        $shipAdress = $validation->isValidRecipientAddress($data->ship_adress);
        $logo       = $validation->isValidURL($data->logo);


        if( $name && $company && $email && $buyCond && $recAdress && $shipAdress && $logo )  {

            $_GET['idClient'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('client.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }

    } elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "product") == 0) {

        $name           = $validation->isValidName($data->name);
        $logo           = $validation->isValidURL($data->logo);
        $price          = $validation->isValidPrice($data->price);
        $description    = $validation->isValidTextField($data->description, "Description");
        $origin         = $validation->isValidTextField($data->origine, "Origin");
        $code           = $validation->isValidTextField($data->code, "Code");
        $format         = $validation->isValidTextField($data->format, "Format");

        if( $name && $logo && $price && $description && $origin && $code && $format )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }

    }  elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "order") == 0) {

        $date               = $validation->isValidDate($data->date_commande);
        $numero_commande    = $validation->isValidID($data->numero_commande);
        $client          = $validation->isValidTextField($data->client, "Client");
        $commentaire    = $validation->isValidComment($data->commentaire);


        if( $date && $numero_commande && $client && $commentaire )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }

    }

/*

    elseif (strcasecmp($url[1], "oauth") == 0 && strcasecmp($url[2], "login") == 0) {

        $username   = $validation->isValidName($data->username);
        $psw        = $validation->isValidURL($data->password);

        if( $username && $psw  )  {

            include('');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }

    } elseif (strcasecmp($url[1], "login") == 0) {


        include('login.php');
    }


*/



}

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}


