<?php
$json = file_get_contents('php://input');
$data = json_decode($json);

$validation = new Validation();


if (strcasecmp($url[1], "client") == 0 && strcasecmp($url[3], "order") == 0) {

//        $date               = $validation->isValidDate($data->date);
    $user               = $validation->isValidID($data->user);
    $commentaire        = $validation->isValidComment($data->commentaire);
    $fkidClient         = $validation->isValidID($data->fkidClient);
    $fkidSupplier       = $validation->isValidID($data->fkidSupplier);
    $products           = $validation->isValidComment($data->produits);


    $isValid = true;
    $errorMessage = "";


    if ( $user && $commentaire && $fkidClient && $fkidSupplier )  {

        foreach ($products as $key => $value) {

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
//                    $_GET['idAbout'] = $url[4];
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
//        $firstName  = $validation->isValidName($data->first_name);
//        $lastName   = $validation->isValidName($data->last_name);
//        $email      = $validation->isValidEmail($data->email);

//        && $firstName && $lastName && $email
    if ( $username && $psw && $fkidClient  )  {


        $_GET['idClient'] = $url[2];
        $_GET['about'] = $url[3];
//            $_GET['idAbout'] = $url[4];
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
//            $_GET['idAbout'] = $url[4];
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
//            $_GET['idAbout'] = $url[4];
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
//            $_GET['idAbout'] = $url[4];
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
//                    $_GET['idAbout'] = $url[4];
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