<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-18
 * Time: 00:27
 */

class Supplier
{
    private $_id;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    public function loadFromDB ()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Supplier WHERE id = ?", ['id', $this->_id]);
    }

    /**Retourne la liste des clients du fournisseur**/
    public function getClientList()
    {
        echo "Client1, Client2";
    }

    /**Retourne la liste des produits du fournisseur**/
    public function getProductList()
    {
        echo "Produit1,Produit2, ...";
    }

    /**Retourne la liste des utilisateurs du fournisseur**/
    public function getUserList()
    {
        echo "Utilisateur1,Utilisateur2, ...";
    }

    /**Retourne la liste des commandes du fournisseur**/
    public function getOrderList()
    {
        echo "Commande1,Commande2, ...";
    }

    /**Supprime tous les clients du fournisseur**/
    public function deleteAllClient()
    {
        echo "Supprimer tous les clients";
    }

    /**Supprime un client du fournisseur**/
    public function deleteClient($idabout)
    {
        echo "Suprimer le client X ";
    }
}
