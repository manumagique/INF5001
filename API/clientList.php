<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 2019-02-17
 * Time: 22:12
 */

$client = new Client();
try
{
    $user->create( array(
        ‘idClient’ => ‘valeur 1’,
        ‘nom’ => ‘valeur 2’,
        'compagnie' => '',
        ‘courriel’ => ‘valeur 1’,
        ‘condition_achat’ => ‘valeur 1’,
        ‘adresseFacturation’ => ‘valeur 1’,
        ‘adresseLivraison’ => ‘valeur 1’,
        ‘logo’ => ‘valeur 1’,
        ‘nb_commande’ => ‘valeur 1’,
                  ));

              }
catch (Exception $e)
{
    die($e->getMessage());
}