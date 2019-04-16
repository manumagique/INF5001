<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-03-17
 * Time: 8:53 PM
 */

include ("../Classes/Validation.php");

#echo '<hr/>';
#echo $_GET['url'] . "<br>";
//use OAuth2\Request;

header('Access-Control-Allow-Origin: *');


#validation du token sile token n'est pas valide l'application stop tout
require_once '../oauth/server.php';
// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}

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
    } elseif (strcasecmp($url[1], "order") == 0) {
        $_GET['idOrder'] = $url[2];
        $_GET['about'] = $url[3];
        $_GET['idAbout'] = $url[4];
        include('order.php');
    } elseif (strcasecmp($url[1], "admin") == 0) {
        $_GET['idAdmin'] = $url[2];
        $_GET['about'] = $url[3];
        $_GET['idAbout'] = $url[4];
        include('admin.php');
    }

// CONDITIONS FOR POST

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $validation = new Validation();


    if (strcasecmp($url[1], "client") == 0 && strcasecmp($url[3], "order") == 0) {

        $date               = $validation->isValidDate($data->date);
        $user               = $validation->isValidID($data->user);
        $commentaire        = $validation->isValidComment($data->commentaire);
        $fkidClient         = $validation->isValidID($data->fkidClient);
        $fkidSupplier       = $validation->isValidID($data->fkidSupplier);
        $products           = $validation->isValidComment($data->produits);


        $isValid = true;
        $errorMessage = "";


        if ( $user && $commentaire && $fkidClient && $fkidSupplier )  {

                foreach ($encoded as $key => $value) {

                    foreach ($value as $pKey => $pValue) {

                        if($pKey == "fkidProduct") {

                            $isValid = $validation->isValidID($pValue);
                            $errorMessage = $validation->getValidationErrorMessage();

                        } elseif ($pKey == "Qty") {

                            $isValid = $validation->isValidQuantity($pValue);
                            $errorMessage = $validation->getValidationErrorMessage();

                        }
                    }
                }

                if($isValid) {

                    $_GET['idClient'] = $url[2];
                    $_GET['about'] = $url[3];
                    $_GET['idAbout'] = $url[4];
                    include('client.php');

                } else {

                    header(trim("HTTP/1.0 400 " . $errorMessage));
                }


        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }


    } elseif (strcasecmp($url[1], "client") == 0 && strcasecmp($url[3], "user") == 0) {


        $username   = $validation->isValidUsername($data->username);
        $psw        = $validation->isValidPsw($data->password);
        $fkidClient = $validation->isValidID($data->fkidClient);
        $firstName  = $validation->isValidName($data->first_name);
        $lastName   = $validation->isValidName($data->last_name);
        $email      = $validation->isValidEmail($data->email);


        if ( $username && $psw && $fkidClient && $firstName && $lastName && $email )  {


            $_GET['idClient'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('client.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }


    } elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "client") == 0) {

        $name       = $validation->isValidName($data->name);
        $company    = $validation->isValidTextField($data->compagny, "Company");
        $email      = $validation->isValidEmail($data->email);
        $buyCond    = $validation->isValidBuyCondition($data->buy_condition);
        $recAdress  = $validation->isValidRecipientAddress($data->rec_adress);
        $shipAdress = $validation->isValidRecipientAddress($data->ship_adress);
        $logo       = $validation->isValidURL($data->logo);


        if ( $name && $company && $email && $buyCond && $recAdress && $shipAdress && $logo )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

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


        if ( $name && $logo && $price && $description && $origin && $code && $format )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }


    }  elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "user") == 0) {

        $username   = $validation->isValidUsername($data->username);
        $psw        = $validation->isValidPsw($data->password);

        if ( $username && $psw  )  {

            $_GET['idSupplier'] = $url[2];
            $_GET['about'] = $url[3];
            $_GET['idAbout'] = $url[4];
            include('supplier.php');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }


    }  elseif (strcasecmp($url[1], "supplier") == 0 && strcasecmp($url[3], "order") == 0) {

        $commentaire        = $validation->isValidComment($data->commentaire);
        $fkidClient         = $validation->isValidID($data->fkidClient);

        $isValid = false;
        $errorMessage = "";

        if ( $fkidClient && $commentaire )  {

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



    } elseif (strcasecmp($url[1], "oauth") == 0 && strcasecmp($url[2], "login") == 0) {

        $username   = $validation->isValidUsername($data->username);
        $psw        = $validation->isValidPsw($data->password);

        if( $username && $psw  )  {

            include('');

        } else {

            header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        }


    } elseif (strcasecmp($url[1], "login") == 0) {

        include('login.php');
    }





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
        $psw        = $validation->isValidURL($data->password);

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



