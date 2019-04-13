<?php

/**
 * Author: Valentina
 * Date: Winter 2019
 */

require_once '../core/init.php';
header('Content-Type: application/json');

require("../FPDF/fpdf181/fpdf.php");
include("../Classes/Database.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // http:...com/api/order/".$idOrder."/print

    $idOrder = $_GET['idOrder'];
    $about = $_GET['about'];

    if($about == "print") {
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        /* ------ Facture ------ */
        $db = Database::getInstance();
        $db->query("SELECT fkidClient FROM ClientOrder WHERE id = ?", array($idOrder));
        $_data = $db->results();
        foreach ($_data as $row) {
            $idClient = $row->fkidClient;
        }
        $db->query("SELECT compagnie FROM Client WHERE idClient = ?", array($idClient));
        $_data = $db->results();
        foreach ($_data as $row) {
            $compagnieName = $row->nom;
        }

        if ($compagnieName == null) {   //à enlever
            $compagnieName = "Compagnie";
        }

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(95, 13, $compagnieName, 0, 0, 'L', 'TRUE');
        $pdf->Cell(95, 13, "Facture", 0, 1, 'R', 'TRUE');
        $pdf->Ln(4);

        /* ------ Commande ------ */
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(36, 5, "Bon de commande : ", 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(59,5, "#".$idOrder,0,0);

        /* ------ Date ------ */
        $db->query("SELECT date FROM ClientOrder WHERE id = ?", array($idOrder));
        $_data = $db->results();
        foreach ($_data as $row) {
            $date = $row->date;
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(76,5, "Date : ", 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(19, 5, $date, 0, 1, 'R');
        $pdf->Ln(4);

        /* ------ Fournisseur ------ */
        $db->query("SELECT fkidSupplier FROM ClientOrder WHERE id = ?", array($idOrder));
        $_data = $db->results();
        foreach ($_data as $row) {
            $idSupplier = $row->fkidSupplier;
        }
        $db->query("SELECT nom FROM Fournisseur WHERE idFournisseur = ?", array($idSupplier));
        $_data = $db->results();
        foreach ($_data as $row) {
            $nameSupplier = $row->nom;
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25,5, "Fournisseur : ", 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(70, 5, $nameSupplier, 0, 0);

        /* ------ Client ------ */
        $db->query("SELECT nom FROM Client WHERE idClient = ?", array($idClient));
        $_data = $db->results();
        foreach ($_data as $row) {
            $nameClient = $row->nom;
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, "Client : ", 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, "$nameClient", 0, 1, 'R');

        /* ------ Utilisateur ------ */
        $db->query("SELECT user FROM ClientOrder WHERE id = ?", array($idOrder));
        $_data = $db->results();
        foreach ($_data as $row) {
            $idUser = $row->user;
        }
        $db->query("SELECT username FROM oauth_users WHERE id = ?", array($idUser));
        $_data = $db->results();
        foreach ($_data as $row) {
            $nameUser = $row->username;
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(184,5, "Utilisateur : ", 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(6, 5, "$nameUser", 0, 1, 'R');

        /* ------ Adresse ------ */
        $db->query("SELECT adresseFacturation FROM Client WHERE idClient = ?", array($idClient));
        $_data = $db->results();
        foreach ($_data as $row) {
            $adresse = $row->adresseFacturation;
        }

        if ($adresse == null) {        //à enlever
            $adresse = " ";
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(160,5, "Adresse de facturation : ", 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 5, "$adresse", 0, 1, 'C');
        $pdf->Ln(10);

        /* ------ Produits titre ------ */
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(95, 15, "Produits", 0, 1);
        $pdf->Ln(4);

        /* ------ Entête table produits ------ */
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(21,10, "Code", 1, 0, 'C', TRUE);
        $pdf->Cell(21, 10, "Nom", 1, 0, 'C', TRUE);
        $pdf->Cell(21,10, "Quantite", 1, 0, 'C', TRUE);
        $pdf->Cell(42,10, "Description", 1, 0, 'C', TRUE);
        $pdf->Cell(21,10, "Origine", 1, 0, 'C', TRUE);
        $pdf->Cell(21,10, "Format", 1, 0, 'C', TRUE);
        $pdf->Cell(21,10, "Prix", 1, 0, 'C', TRUE);
        $pdf->Cell(21,10, "Prix total", 1, 1, 'C', TRUE);

        $pdf->SetFont('Arial', '', 9);

        $sousTotal = 0;

        $db->query("SELECT fkidProduct FROM clientOrderDetail WHERE fkid_ClientOrder = ?", array($idOrder));
        $data = $db->results();

        foreach ($data as $_row) {
            $idProduct = $_row->fkidProduct;

            /* ------ Code produit ------ */
            $db->query("SELECT code FROM Product WHERE idProduct = ?", array($idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $codeProduct = $row->code;
            }
            if ($codeProduct == null) {     //à enlever
                $codeProduct = "#";
            }

            $pdf->Cell(21,10, $codeProduct, 1, 0, 'C');

            /* ------ Nom produit ------ */
            $db->query("SELECT nom FROM Product WHERE idProduct = ?", array($idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $nomProduct = $row->nom;
            }
            $pdf->Cell(21, 10, $nomProduct, 1, 0);

            /* ------ Quantité ------ */
            $db->query("SELECT Qty FROM clientOrderDetail WHERE fkid_ClientOrder = ? AND fkidProduct = ?", array($idOrder, $idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $quantity = $row->Qty;
            }

            $pdf->Cell(21,10, $quantity, 1, 0, 'C');

            /* ------ Description produit ------ */
            $db->query("SELECT description FROM Product WHERE idProduct = ?", array($idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $descriptionProduct = $row->description;
            }
            if ($descriptionProduct == null) {
                $descriptionProduct = "Non specifie";
            }
            $pdf->Cell(42,10, $descriptionProduct, 1, 0);

            /* ------ Origine produit ------ */
            $db->query("SELECT origine FROM Product WHERE idProduct = ?", array($idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $origineProduct = $row->origine;
            }
            if ($origineProduct == null) {
                $origineProduct = "Non specifie";
            }
            $pdf->Cell(21,10, $origineProduct, 1, 0);

            /* ------ Format produit ------ */
            $db->query("SELECT format FROM Product WHERE idProduct = ?", array($idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $formatProduct = $row->origine;
            }
            if ($formatProduct == null) {
                $formatProduct = "Non specifie";
            }
            $pdf->Cell(21,10, $formatProduct, 1, 0);

            /* ------ Prix produit ------ */
            $db->query("SELECT prix FROM Product WHERE idProduct = ?", array($idProduct));
            $_data = $db->results();
            foreach ($_data as $row) {
                $prixProduct = $row->prix;
            }
            $pdf->Cell(21,10, $prixProduct, 1, 0, 'C');

            /* ------ Prix total ------ */
            $totalPrice = $quantity * $prixProduct;
            $total = number_format($totalPrice, 2, '.', ' ');
            $pdf->Cell(21,10, $total, 1, 1, 'R');

            $sousTotal = $sousTotal + $totalPrice;

        }

        /* ------ Sous-total ------ */
        $total = number_format($sousTotal, 2, '.', ' ');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(168,10, "Sous-total", 1, 0, 'R', 'TRUE');
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(21,10, $total, 1, 1, 'R', 'TRUE');

        /* ------ TVQ ------ */
        $tvq = $sousTotal * 9.975 / 100;
        $total = number_format($tvq, 2, '.', ' ');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(168,10, "TVQ 9.975%", 1, 0, 'R', 'TRUE');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(21,10, $total, 1, 1, 'R', 'TRUE');

        /* ------ TPS ------ */
        $tps = $sousTotal * 5 / 100;
        $total = number_format($tps, 2, '.', ' ');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(168,10, "TPS 5%", 1, 0, 'R', 'TRUE');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(21,10, $total, 1, 1, 'R', 'TRUE');

        /* ------ Grand total ------ */
        $grandTotal = $sousTotal + $tps + $tvq;
        $total = number_format($grandTotal, 2, '.', ' ');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(168,10, "Grand total", 1, 0, 'R', 'TRUE');
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(21,10, $total, 1, 1, 'R', 'TRUE');

        $pdf->Output();

        }

}