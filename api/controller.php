<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-03-17
 * Time: 8:53 PM
 */

include_once '../Functions/cors.php';
cors();
$url = explode('/', $_GET['url']);
$sizeUrl = sizeof($url);
$_GET['idSupplier']     = "";
$_GET['idClient']       = "";
$_GET['idProduit']      = "";
$_GET['idAdmin']        = "";
$_GET['about']          = "";
$_GET['idAbout']        = "";


include ("../Classes/Validation.php");

#echo '<hr/>';
#echo $_GET['url'] . "<br>";
//use OAuth2\Request;

#validation du token sile token n'est pas valide l'application stop tout
require_once '../oauth/server.php';
// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}






if ($_SERVER['REQUEST_METHOD'] == 'GET') {


    if (strcasecmp($url[1], "supplier") == 0) {
        $_GET['idSupplier'] = $url[2];
        $_GET['about'] = $url[3];
        if (isset($url[4]))
        {
            $_GET['idAbout'] = $url[4];
        }
        include('supplier.php');
    } elseif (strcasecmp($url[1], "client") == 0) {
        $_GET['idClient'] = $url[2];
        $_GET['about'] = $url[3];
        if (isset($url[4]))
        {
            $_GET['idAbout'] = $url[4];
        }
        include('client.php');
    } elseif (strcasecmp($url[1], "order") == 0) {
        $_GET['idOrder'] = $url[2];
        $_GET['about'] = $url[3];
        if (isset($url[4]))
        {
            $_GET['idAbout'] = $url[4];
        }
        include('order.php');
    } elseif (strcasecmp($url[1], "admin") == 0) {
        $_GET['idAdmin'] = $url[2];
        $_GET['about'] = $url[3];
        if (isset($url[4])) {
            $_GET['idAbout'] = $url[4];
        }
        include('admin.php');
//    }
    }elseif (strcasecmp($url[1], "user") == 0) {
        $token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
        include_once '../Classes/PlatformUser.php';
        $usr = new platformUser();
        $usr->getUserInfo($token['user_id']);

    }

// CONDITIONS FOR POST

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  include_once 'ctrlPost.php';





// CONDITIONS POUR PUT

} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $validation = new Validation();


    if (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "client") == 0) {

        $name       = $validation->isValidName($data->name);
        $company    = $validation->isValidTextField($data->compagny, "Company");
        $email      = $validation->isValidEmail($data->email);
        $buyCond    = $validation->isValidBuyCondition($data->buy_condition);
        $recAdress  = $validation->isValidRecipientAddress($data->rec_adress);
        $shipAdress = $validation->isValidRecipientAddress($data->ship_adress);
        $logo       = $validation->isValidURL($data->logo);


        if ($name && $company && $email && $buyCond && $recAdress && $shipAdress && $logo) {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));

        }


    } elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "produit") == 0) {

        $name           = $validation->isValidName($data->name);
        $logo           = $validation->isValidURL($data->logo);
        $price          = $validation->isValidPrice($data->price);
        $description    = $validation->isValidTextField($data->description, "Description");
        $origin         = $validation->isValidTextField($data->origine, "Origin");
        $code           = $validation->isValidTextField($data->code, "Code");
        $format         = $validation->isValidTextField($data->format, "Format");


        if ( $name && $logo && $price && $description && $origin && $code && $format )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }


    } elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "order") == 0) {

        $commentaire        = $validation->isValidComment($data->commentaire);
        $fkidClient         = $validation->isValidID($data->fkidClient);
        $done               = $validation->isValidStatus($data->done);

        $isValid = false;
        $errorMessage = "";

        if ( $fkidClient && $commentaire && $done )  {

            foreach ($data->Produits as $key => $value) {

                foreach ($value as $pKey => $pValue) {

                    if($pKey == "fkidProduct") {

                        $isValid = $validation->isValidID($pValue);
                        $errorMessage = $validation->getValidationErrorMessage();

                    } elseif ($pKey == "quantite") {

                        $isValid = $validation->isValidQuantity($pValue);
                        $errorMessage = $validation->getValidationErrorMessage();

                    }
                }
            }

            if($isValid) {

                $_GET['idSupplier'] = $url[2];
                $_GET['about'] = $url[3];
                $_GET['idAbout'] = $url[4];
                include('supplier.php');

            } else {

                header(trim("HTTP/1.0 400 " . $errorMessage));
            }


        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }



    }  elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "user") == 0) {

        $username   = $validation->isValidName($data->username);
        $psw        = $validation->isValidPsw($data->password);

        if ( $username && $psw  )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }

    }


// CONDITIONS FOR DELETE

} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {


    $_GET['idSupplier'] = $url[2];
    $_GET['about'] = $url[3];
    $_GET['idAbout'] = $url[4];
    include('supplier.php');

}



