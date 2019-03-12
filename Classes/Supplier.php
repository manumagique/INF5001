<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-18
 * Time: 00:27
 */
/**Jade**/
class Supplier
{
    private $_id;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    /**Retourne le nom d'un fournisseur**/
    public function getSupplier ()
    {
        $db = Database::getInstance();
        $req = $db->preapre('SELECT nom  FROM Fournisseur WHERE idFournisseur = ?');
        $req ->execute(array(this));
    }

    /**Retourne la liste des clients du fournisseur**/
    public function getClientList()
    {
        $db = Database::getInstance();
        $req = $db->prepare('SELECT nom, courriel, condition_achat, adresseFacturation, adresseLivraison FROM Client WHERE fkidSupplier = ?');
        $req ->execute(array(this));
    }

    /**Retourne la fiche détaillée d'un client  du fournisseur**/
    public function getClient($idClient)
    {
        $db = Database::getInstance();
        $req = $db->prepare('SELECT nom, courriel, condition_achat, adresseFacturation, adresseLivraison FROM Client WHERE fkidSupplier = ? AND idClient = ?');
        $req ->execute(array(this,$idClient));
    }

    /**Retourne la liste des produits du fournisseur**/
    public function getProductList()
    {
        $db = Database::getInstance();
        $req = $db->prepare('SELECT nom, prix, description, origine, code, format FROM Produit WHERE fkidSupplier = ?');
        $req ->execute(array(this));
    }

    /**Retourne le détail d'un produit du fournisseur**/
    public function getProduct($idProduct)
    {
        $db = Database::getInstance();
        $req = $db->prepare('SELECT nom, prix, description, origine, code, format FROM Produit WHERE fkidSupplier = ? AND idProduit=?');
        $req ->execute(array(this, $idProduct));
    }

    /**Retourne la liste des utilisateurs du fournisseur**/
    public function getUserList()
    {
        $db = Database::getInstance();
        $req = $db->prepare('SELECT username FROM User WHERE fkidSupplier = ?');
        $req ->execute(array(this));
    }

    /**Retourne d'un utilisateur du fournisseur**/
    public function getUser($idUser)
    {
        $db = Database::getInstance();
        $req = $db->prepare('SELECT username FROM User WHERE fkidSupplier = ? AND id = ?');
        $req ->execute(array(this, $idUser));
    }

    /**ATTENDRE TABLE BASE DE DONNÉES COMMANDE **/
//    /**Retourne la liste des commandes du fournisseur**/
//    public function getOrderList()
//    {
//       $db = Database::getInstance();
//       $req = $db->prepare('SELECT  FROM Order WHERE fkidSupplier = ? ');
//        $req ->execute(array(this));
//    }
//
//    /**Retourne une commande du fournisseur**/
//    public function getOrder($idOrder)
//    {
//        $db = Database::getInstance();
//        $req = $db->prepare('SELECT  FROM Order WHERE fkidSupplier = ? AND idOrder = ?');
//        $req ->execute(array(this, $idUser));
//    }


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

    public function deleteAllProducts()
    {

    }

}
