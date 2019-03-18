<?php

/*CETTE PAGE DEVRAIT ETRE SUPPRIMER -> NE SERT À RIEN SELON JADE*/

///**
// * Created by PhpStorm.
// * User: emmanuelboyer
// * Date: 2019-02-20
// * Time: 01:46
// */
//require_once '../core/init.php';
//header('Content-Type: application/json');
//
//if ($_SERVER['REQUEST_METHOD'] == 'GET')
//{
//    $o = new produit($_GET['idProduit']);
//    var_dump($o);
//
//    $o->set_nom('nouveau nom');
//    $o->updateCHeck();
//
////    $data  = new SupplierProduits($_GET['idSupplier']);
////
////    echo json_encode($data->data());
//}
//elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
//{
//    $data = json_decode(file_get_contents("php://input"));
//
//    $produit = new Produit();
//
//
////    try
////    {
////        $produit->create( array(
////                "name" => $data->nomProduit,
////                "prix" => $data->prix,
////                "description" => $data->description,
////                "origine" => $data->origine,
////                "code" => $data->code,
////                "format" => $data->format,
////                "fkidSupplier" => $data->idSupplier
////        ));
////
////    }
////    catch (Exception $e)
////    {
////        die($e->getMessage());
////    }
//
//
//}
//elseif ($_SERVER['REQUEST_METHOD'] == 'PUT')
//{
//
//}
//elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE')
//{
//
//}