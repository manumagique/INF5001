<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 9:52 AM
 */
function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

// use a secure hashing algorithm when storing passwords. Override this for your application
function hashPassword($password)
{
    return sha1($password);
}