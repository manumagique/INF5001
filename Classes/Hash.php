<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 12:01 PM
 */

class Hash
{
    public static function make($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length)
    {
        return random_bytes($length);
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}