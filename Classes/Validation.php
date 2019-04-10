<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 2:47 AM
 */

class Validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    private $validationResults = array();

    public function __construct()
    {
        $this->_db =Database::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules)
        {
            foreach ($rules as $rule => $ruleValue)
            {
                $value = trim($source[$item]);
                $item = escape($item);
                if ($rule === 'required' && empty($value))
                {
                    $this->addError("{$item} is required");
                }
                else if (!empty($value))
                {
                    switch ($rule)
                    {
                        case 'min' :
                            if (strlen($value) < $ruleValue)
                            {
                                $this->addError("{$item} doit être un minimum de  {$ruleValue} caratères");
                            }
                            break;
                        case 'max' :
                            if (strlen($value) > $ruleValue)
                            {
                                $this->addError("{$item} doit être un maximum de  {$ruleValue} caratères");
                            }
                            break;
                        case 'matches' :
                                if ($value != $source[$ruleValue])
                                {
                                    $this->addError("{$ruleValue} doit être égale à {$item}");
                                }
                            break;
                        case 'unique' :
                                //$check = $this->_db->query();
                                $check = $this->_db->get($ruleValue, array($item, '=', $value) );
                                if ($check->count())
                                {
                                    $this->addError("{$item} est déjà utilisé.");
                                }
                            break;
                        case 'numeric' :
                            //$check = $this->_db->query();
                            $check = $this->_db->get($ruleValue, array($item, '=', $value) );
                            if ($check->count())
                            {
                                $this->addError("{$item} est déjà utilisé.");
                            }
                            break;
                    }
                }
            }
            if (empty($this->_errors))
            {
                $this->_passed = true;
            }
            return $this;
        }
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }
    public function errors()
    {
        return $this->_errors;
    }
    public function passed()
    {
        return $this->_passed;
    }



// Validation for Client's form fields

    public function getValidationResults()  {
        return $this->validationResults;
    }

    public function isValidName($name)  {
        $result = true;
        $length = 45;

        if (empty($name)) {
            array_push($validationResults, "The field Client Name can't be empty.");
            $result = false;
        } else {
            if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
                array_push($validationResults, "Field Name can only contain letters and white spaces.");
                $result = false;
            }
            if (strlen($name) > $length) {
                array_push($validationResults, "The field Client Name can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }

    public function isValidCompany($company)  {
        $result = true;
        $length = 45;

        if (empty($company)) {
            array_push($validationResults, "The field Client Company can't be empty.");
            $result = false;
        } else {
            if (strlen($company) > $length) {
                array_push($validationResults, "The field Client Company can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }

    public function isValidEmail($email)  {
        $result = true;
        $length = 45;

        if (empty($email)) {
            array_push($validationResults, "The field Client Email can't be empty.");
            $result = false;
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($validationResults, "Invalid Email");
                $result = false;
            }
            if (strlen($email) > $length) {
                array_push($validationResults, "The field Client Email can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }

    public function isValidBuyCondition($buyCondition)  {
        $result = true;
        $length = 45;

        if (empty($buyCondition)) {
            array_push($validationResults, "The field Client Buy Condition can't be empty.");
            $result = false;
        } else {
            if (strlen($buyCondition) > $length) {
                array_push($validationResults, "The field Client Buy Condition can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }

    public function isValidRecipientAddress($address)  {
        $result = true;
        $length = 200;

        if (empty($address)) {
            array_push($validationResults, "The field Client Recipient Address can't be empty.");
            $result = false;
        } else {
            if (strlen($address) > $length) {
                array_push($validationResults, "The field Client Recipient Address can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }

    public function isValidShippingAddress($address)  {
        $result = true;
        $length = 200;

        if (empty($address)) {
            array_push($validationResults, "The field Client Shipping Address can't be empty.");
            $result = false;
        } else {
            if (strlen($address) > $length) {
                array_push($validationResults, "The field Client Shipping Address can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }

    public function isValidURL($url)  {
        $result = true;
        $length = 16535;

        if (empty($url)) {
            array_push($validationResults, "The field Client Logo URL can't be empty.");
            $result = false;
        } else {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                array_push($validationResults, "The field Client Logo URL can't be empty.");
                $result = false;
            }
            if (strlen($url) > $length) {
                array_push($validationResults, "The field Client Logo URL can't be longer than " . $length . " characters.");
                $result = false;
            }
        }
        return $result;
    }











}