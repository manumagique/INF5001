<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-17
 * Time: 21:30
 */

$listeProduits;
$db = Database::getInstance();

$listeProduits = $db->query('SELECT * FROM Product');
$res = json_encode($data);

//if ($_GET['supplierId'] ) {
//
//    $listeProduits = $db->query('SELECT * FROM Produit');
//    $res = json_encode($data);
//
//}




/* chercher les données des produits ---> essai */
/* 
 * $lien = mysql_connect("69.28.199.20", "lango721_inm5001", "?h17b+gplF;H");
 * mysql_select_db("lango721_gestiondecommandes", $lien) or die(mysql_error());
 * 
 * // requete
 * 
 * $query = "SELECT * FROM `Produit`";
 * $res = mysql_query($query, $lien) or die($query . " - " . mysql_error());
 * 
 * // insérer les données dans un tableau
 * 
 * $listeProduits = array();
 * $listeProduits["donnees"] = array();
 * 
 * if (mysql_num_rows($res) > 0) {
 * 
 *      while ($ligne = mysql_fetch_assoc($res)) {
 *          extract($ligne);
 *          
 *          $proprietesProduit = array(
 *              "id" => $_id,
 *              "name" => $_nomProduit,
 *              "prix" => $_prix,
 *              "description" => $_description,
 *              "origine" => $_origine,
 *              "code" => $_code,
 *              "format" => $_format,
 *              "logo" => $_logo
 *          );
 *          
 *          array_push($listeProduits["donnees"], $proprietesProduit);
 *      }
 *      
 *      json_encode($listeProduits);
 * }     
 * 
 * mysql_close($lien);
*/

