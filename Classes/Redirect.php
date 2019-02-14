<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 12:54 PM
 */

class Redirect
{
    public static function to($location = null)
    {
        if ($location)
        {
            if (is_numeric($location))
                switch ($location)
                {
                    case 404:
                        header('HTTP1.0 404 Not Found');
                        include 'includes/errors/404.php';
                        exit();
                        break;
                }
            header('location : ' . $location);
            exit();
        }
    }
}