<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-18
 * Time: 00:58
 */
require_once '../core/init.php';
header('Content-Type: application/json');
if (isset($_GET))
{
    $data  = new SupplierClientsList($_GET['idSupplier']);
    $res = array('data', $data->getDB()->results());
    $rrr = $data->data();
    $arr = array(
         array('id' => '1','nom'=> 'chez el gros', 'courriel' => 'llll@kkk.vom'),
         array('id' => '2', 'nom'=> 'chez la folle', 'courriel' => 'lafolle@kkk.vom'),
    );
    $arr2 = array();
    $value = array();
    foreach ($rrr as $value){
        array_push($arr2, array($value));
    }

    $json2 = json_encode($arr2);
    $json =  json_encode($arr);
    echo $json2;






}