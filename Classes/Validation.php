<?php
/**
 * Created by PhpStorm.
 * User: andre langoni
 * Date: 2019-04-11
 * Time: 2:47 AM
 */

class Validation
{

    private $validationErrorMessage = null;

    public function __construct(){}

    public function getValidationErrorMessage()  {
        return $this->validationErrorMessage;
    }
    public function setValidationErrorMessage($message)  {
        return $this->validationErrorMessage = $message;
    }

// Validation for Client's form fields


    public function isValidTextField($txt, $fieldName)  {
        $result = true;
        $length = 45;

        if (empty($txt)) {
            $this->setValidationErrorMessage("The field " . $fieldName . " can't be empty.");
            $result = false;
        } elseif (strlen($txt) > $length) {
            $this->setValidationErrorMessage("The field " . $fieldName . " can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidName($name)  {
        $result = true;
        $length = 45;

        if (empty($name)) {
            $this->setValidationErrorMessage("The field Name can't be empty.");
            $result = false;
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $this->setValidationErrorMessage("Field Name can only contain letters and white spaces.");
            $result = false;
        } elseif (strlen($name) > $length) {
            $this->setValidationErrorMessage("The field Name can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidEmail($email)  {
        $result = true;
        $length = 45;

        if (empty($email)) {
            $this->setValidationErrorMessage("The field Email can't be empty.");
            $result = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setValidationErrorMessage("Invalid Email");
            $result = false;
        } elseif (strlen($email) > $length) {
            $this->setValidationErrorMessage("The field Email can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidBuyCondition($buyCondition)  {
        $result = true;
        $length = 45;

        if (empty($buyCondition)) {
            $this->setValidationErrorMessage("The field Buy Condition can't be empty.");
            $result = false;
        } elseif (strlen($buyCondition) > $length) {
            $this->setValidationErrorMessage("The field Buy Condition can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidRecipientAddress($address)  {
        $result = true;
        $length = 200;

        if (empty($address)) {
            $this->setValidationErrorMessage("The field Recipient Address can't be empty.");
            $result = false;
        } elseif (strlen($address) > $length) {
            $this->setValidationErrorMessage("The field Recipient Address can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidShippingAddress($address)  {
        $result = true;
        $length = 200;

        if (empty($address)) {
            $this->setValidationErrorMessage("The field Shipping Address can't be empty.");
            $result = false;
        } elseif (strlen($address) > $length) {
            $this->setValidationErrorMessage("The field Shipping Address can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidURL($url)  {
        $result = true;
        $length = 16535;

        if (empty($url)) {
            $this->setValidationErrorMessage("The field Logo URL can't be empty.");
            $result = false;
        } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->setValidationErrorMessage("The RUL is not valid.");
            $result = false;
        } elseif (strlen($url) > $length) {
            $this->setValidationErrorMessage("The field Logo URL can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }



    // Validation for Product's form fields

    public function isValidPrice($price)  {
        $result = true;
        $length = 8;

        if (empty($price)) {
            $this->setValidationErrorMessage("The field Price can't be empty.");
            $result = false;
        } elseif (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
            $this->setValidationErrorMessage("Field Price can only contain numbers and '.' .");
            $result = false;
        } elseif (strlen($price) > $length) {
            $this->setValidationErrorMessage("The field Price can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    // Validation for Product's Order form fields

    public function isValidDate($date) {

        $result = true;

        if(!(date('Y-m-d', strtotime($date)) == $date)) {
            $this->setValidationErrorMessage("The field Date isn't valid.");
            $result = false;
        }

        return $result;
    }


    public function isValidID($id) {

        $result = true;
        $length = 11;

        if (empty($id)) {
            $this->setValidationErrorMessage("The field User can't be empty.");
            $result = false;
        } elseif (!preg_match('/^[0-9\s]+$/', $id)) {
            $this->setValidationErrorMessage("Field ID can only contain numbers.");
            $result = false;
        } elseif (strlen($id) > $length) {
            $this->setValidationErrorMessage("The field ID can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidComment($comment)  {
        $result = true;
        $length = 200;

        if (empty($comment)) {
            $this->setValidationErrorMessage("The field Comment can't be empty.");
            $result = false;
        } elseif (strlen($comment) > $length) {
            $this->setValidationErrorMessage("The field Comment can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidStatus($status)  {
        $result = true;

        if (!($status >= 0 && $status <= 1)) {
                $this->setValidationErrorMessage("Field Status can only contain 0 or 1.");
                $result = false;
        }

        return $result;
    }

    public function isValidBoolean($bool, $field)  {
        $result = true;

        if (empty($bool)) {
            $this->setValidationErrorMessage("The field " . $field . " can't be empty.");
            $result = false;
        } elseif ( !$bool == 0) {
            $this->setValidationErrorMessage("The Field " . $field . " can only contain 0 or 1.");
            $result = false;
        }

        return $result;
    }

    public function isValidQuantity($quantity) {

        $result = true;

        if (empty($quantity)) {
            $this->setValidationErrorMessage("The field Quantity can't be empty.");
            $result = false;
        } elseif (!preg_match('/^[0-9\s]+$/', $quantity)) {
            $this->setValidationErrorMessage("Field Quantity can only contain numbers.");
            $result = false;
        }

        return $result;
    }


    public function isValidUsername($username) {

        $result = true;
        $length = 100;

        if (empty($username)) {
            $this->setValidationErrorMessage("The field Username can't be empty.");
            $result = false;
        } elseif (strlen($username) > $length) {
            $this->setValidationErrorMessage("Username or Password invalid.");
            $result = false;
        }

        return $result;
    }


    public function isValidPsw($psw) {

        $result = true;
        $length = 64;

        if (empty($psw)) {
            $this->setValidationErrorMessage("The field Password can't be empty.");
            $result = false;
        } elseif (strlen($psw) > $length) {
            $this->setValidationErrorMessage("Username or Password invalid.");
            $result = false;
        }

        return $result;
    }




}







/*

$json = '{
    "name":"test modif",
    "compagny":"test company",
    "email":"testmail@gmail.com",
    "buy_condition":"test",
    "rec_adress":"test adresse",
    "ship_adress":"test ship adress",
    "logo": "https://recipes.timesofindia.com/photo/53110049.cms"
}';


if($data=json_decode($json)) {


    $validation = new Validation();



    $name = $validation->isValidName($data->name);
    $company = $validation->isValidTextField($data->compagny, "Company");
    $email = $validation->isValidEmail($data->email);
    $buyCond = $validation->isValidBuyCondition($data->buy_condition);
    $recAdress = $validation->isValidRecipientAddress($data->rec_adress);
    $shipAdress = $validation->isValidRecipientAddress($data->ship_adress);
    $logo = $validation->isValidURL($data->logo);


    if ($name && $company && $email && $buyCond && $recAdress && $shipAdress && $logo) {

        echo  " FUNCIONA";

    } else {

        header(trim("HTTP/1.0 400 " . $validation->getValidationErrorMessage()));
        echo $validation->getValidationErrorMessage();
    }

} else {
    echo  "NAO FUNCIONA 2";
}

*/


/*
// test section
$teste = new Validation();
$value = "Texte";

if($teste->isValidUsername($value))
    echo "TRUE";

else
    echo "FALSE - " . $teste->getValidationErrorMessage();

*/




