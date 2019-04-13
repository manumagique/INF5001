<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 2:47 AM
 */

class Validation
{

    private $validationResult = null;

    public function __construct(){}

    public function getValidationResults()  {
        return $this->validationResult;
    }
    public function setValidationResults($result)  {
        return $this->validationResult = $result;
    }

// Validation for Client's form fields


    public function isValidTextField($txt, $fieldName)  {
        $result = true;
        $length = 45;

        if (empty($txt)) {
            $this->setValidationResults("The field " . $fieldName . " can't be empty.");
            $result = false;
        } elseif (strlen($txt) > $length) {
            $this->setValidationResults("The field " . $fieldName . " can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }

    public function isValidName($name)  {
        $result = true;
        $length = 45;

        if (empty($name)) {
            $this->setValidationResults("The field Name can't be empty.");
            $result = false;
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $this->setValidationResults("Field Name can only contain letters and white spaces.");
            $result = false;
        } elseif (strlen($name) > $length) {
            $this->setValidationResults("The field Name can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }

    public function isValidEmail($email)  {
        $result = true;
        $length = 45;

        if (empty($email)) {
            $this->setValidationResults("The field Email can't be empty.");
            $result = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setValidationResults("Invalid Email");
            $result = false;
        } elseif (strlen($email) > $length) {
            $this->setValidationResults("The field Email can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }

    public function isValidBuyCondition($buyCondition)  {
        $result = true;
        $length = 45;

        if (empty($buyCondition)) {
            $this->setValidationResults("The field Buy Condition can't be empty.");
            $result = false;
        } elseif (strlen($buyCondition) > $length) {
            $this->setValidationResults("The field Buy Condition can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }

    public function isValidRecipientAddress($address)  {
        $result = true;
        $length = 200;

        if (empty($address)) {
            $this->setValidationResults("The field Recipient Address can't be empty.");
            $result = false;
        } elseif (strlen($address) > $length) {
            $this->setValidationResults("The field Recipient Address can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }

    public function isValidShippingAddress($address)  {
        $result = true;
        $length = 200;

        if (empty($address)) {
            $this->setValidationResults("The field Shipping Address can't be empty.");
            $result = false;
        } elseif (strlen($address) > $length) {
            $this->setValidationResults("The field Shipping Address can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }

    public function isValidURL($url)  {
        $result = true;
        $length = 16535;

        if (empty($url)) {
            $this->setValidationResults("The field Logo URL can't be empty.");
            $result = false;
        } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->setValidationResults("The RUL is not valid.");
            $result = false;
        } elseif (strlen($url) > $length) {
            $this->setValidationResults("The field Logo URL can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }



    // Validation for Product's form fields

    public function isValidPrice($price)  {
        $result = true;
        $length = 8;

        if (empty($price)) {
            $this->setValidationResults("The field Price can't be empty.");
            $result = false;
        } elseif (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
            $this->setValidationResults("Field Price can only contain numbers and '.' .");
            $result = false;
        } elseif (strlen($price) > $length) {
            $this->setValidationResults("The field Price can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    // Validation for Product's Order form fields

    function isValidDate($date) {

        $result = true;

        if(!(date('Y-m-d H:i:s', strtotime($date)) == $date)) {
            $this->setValidationResults("The field Date isn't valid.");
            $result = false;
        }

        return $result;
    }


    function isValidID($id) {

        $result = true;
        $length = 11;

        if (empty($id)) {
            $this->setValidationResults("The field User can't be empty.");
            $result = false;
        } elseif (!preg_match('/^[0-9.\s]+$/', $id)) {
            $this->setValidationResults("Field User can only contain numbers and '.' .");
            $result = false;
        } elseif (strlen($id) > $length) {
            $this->setValidationResults("The field User can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidComment($comment)  {
        $result = true;
        $length = 200;

        if (empty($comment)) {
            $this->setValidationResults("The field Comment can't be empty.");
            $result = false;
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $comment)) {
            $this->setValidationResults("Field Comment can only contain letters and white spaces.");
            $result = false;
        } elseif (strlen($comment) > $length) {
            $this->setValidationResults("The field Comment can't be longer than " . $length . " characters.");
            $result = false;
        }

        return $result;
    }


    public function isValidStatus($status)  {
        $result = true;

        if (!($status >= 0 && $status <= 1)) {
                $this->setValidationResults("Field Status can only contain 0 or 1.");
                $result = false;
        }

        return $result;
    }

    public function isValidQuantity($quantity)  {
        $result = true;

        if (empty($quantity)) {
            $this->setValidationResults("The field Quantity can't be empty.");
            $result = false;
        } elseif ( !$quantity == 0) {
            $this->setValidationResults("Field Quantity can only contain 0 or 1.");
            $result = false;
        }

        return $result;
    }















}






$teste = new Validation();
$value = 5;

if( $teste->isValidStatus($value) ) {
    echo "TRUE " . $teste->getValidationResults() . $teste->isValidStatus($value);
} else {
    echo "FALSE " . $teste->getValidationResults() . $teste->isValidStatus($value);
}