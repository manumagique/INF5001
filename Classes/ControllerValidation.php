<?php
/**
 * Created by PhpStorm.
 * User: LANGONI
 * Date: 2019-03-19
 * Time: 8:25 PM
 */

class ControllerValidation {

    private $param;

    public function __construct($param) {
        $this->param = $param;
    }

    /**
     * @return bool
     */
    public function isValidStr() {
        $value = true;
        if( is_null( $this->param ) || empty($this->param) )
            $value = false;

        return $value;
    }

    /**
     * @return bool
     */
    public function isOnlyNumbers() {
        $value = false;
        if (preg_match('/^[0-9]+$/', $this->param))
            // contains only numbers 0-9
            $value = true;

        return $value;
    }

    /**
     * @return bool
     */
    public function isOnlyLetters() {
        $value = false;
        if (preg_match('/[a-z]/i', $this->param))
            // contains only letters
            $value = true;

        return $value;
    }




}