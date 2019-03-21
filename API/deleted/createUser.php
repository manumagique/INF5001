<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 12:04
 */

require_once '../core/init.php';
header('Content-Type: application/json');

if (isset($_POST))
{
    $data = json_decode(file_get_contents("php://input"));

    $user = new User();
    $salt = Hash::salt(32);
    $username = $data->username;
    try
    {
        $user->create( array(
            'username' => $data->username,
            'password' => Hash::make($data->password, $salt),
            'fkidClient' => $data->idCLient,
            'fkidSupplier' => $data->idSupplier,
            'salt' => $salt
        ));


    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
} else {
    echo 'no data';
}