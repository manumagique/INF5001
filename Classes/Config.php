<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-12
 * Time: 11:44 PM
 */

class Config
{
    public static function get($path = null)
    {
        if ($path)
        {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit)
            {
                if (isset($config[$bit]))
                {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}