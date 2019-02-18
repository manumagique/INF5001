<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-17
 * Time: 21:30
 */

$listeProduits = array();
$db = Database::getInstance();



$listeProduits = $db->query('SELECT * FROM Produit');


$res = $db->toJson();




