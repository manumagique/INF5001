<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 2019-02-17
 * Time: 22:12
 */
require_once '../core/init.php';
header('Content-Type: application/json');

if (isset($_POST))
{
    $data = json_decode(file_get_contents("php://input"));

    $client = new client();
    $salt = Hash::salt(32);

    try
    {
        $client->create( array(
            'nom' => $data->nom,
            'courriel' => $data->courriel,
            'coundition_achat' => $data->coundition_achat,
            'adresseFacturation' => $data->adresseFacturation,
            'adresseLivraison' => $data->adresseLivraison,
            'fkidSupplier' => $data->fkidSupplier
        ));


    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
} else {
    echo 'no data';
}