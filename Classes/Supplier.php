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
        $db->query("SELECT * FROM Fournisseur WHERE idFournisseur = ?", array(this));
//        $req = $db->preapre('SELECT nom  FROM Fournisseur WHERE idFournisseur = ?');
//        $req ->execute(array(this));
    }

    /**Retourne la liste des clients du fournisseur**/
    public function getClientList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE fkidSupplier = ?", array(this));

//        $req = $db->prepare('SELECT nom, courriel, condition_achat, adresseFacturation, adresseLivraison FROM Client WHERE fkidSupplier = ?');
//        $req ->execute(array(this));
    }

    /**Retourne la fiche détaillée d'un client  du fournisseur**/
    public function getClient($idClient)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE fkidSupplier = ? AND idClient = ?", array(this,$idClient));

//        $req = $db->prepare('SELECT nom, courriel, condition_achat, adresseFacturation, adresseLivraison FROM Client WHERE fkidSupplier = ? AND idClient = ?');
//        $req ->execute(array(this,$idClient));
    }

    /**Retourne la liste des produits du fournisseur**/
    public function getProductList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Produit WHERE fkidSupplier = ?", array(this));

//        $req = $db->prepare('SELECT nom, prix, description, origine, code, format FROM Produit WHERE fkidSupplier = ?');
//        $req ->execute(array(this));
    }

    /**Retourne le détail d'un produit du fournisseur**/
    public function getProduct($idProduct)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Produit WHERE fkidSupplier = ? AND idProduit = ?", array(this, $idProduct));

//        $req = $db->prepare('SELECT nom, prix, description, origine, code, format FROM Produit WHERE fkidSupplier = ? AND idProduit=?');
//        $req ->execute(array(this, $idProduct));
    }

    /**Retourne la liste des utilisateurs du fournisseur**/
    public function getUserList()
    {
        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidSupplier = ?", array(this));

//        $req = $db->prepare('SELECT username FROM User WHERE fkidSupplier = ?');
//        $req ->execute(array(this));
    }

    /**Retourne d'un utilisateur du fournisseur**/
    public function getUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidSupplier = ? AND id = ?", array(this, $idUser));


//        $req = $db->prepare('SELECT username FROM User WHERE fkidSupplier = ? AND id = ?');
//        $req ->execute(array(this, $idUser));
    }

    /**ATTENDRE TABLE BASE DE DONNÉES COMMANDE **/
//    /**Retourne la liste des commandes du fournisseur**/
//    public function getOrderList()
//    {
//       $db = Database::getInstance();
//       $db->query("SELECT username FROM Order WHERE fkidSupplier = ? ", array(this));
////       $req = $db->prepare('SELECT  FROM Order WHERE fkidSupplier = ? ');
////        $req ->execute(array(this));
//    }
//
//    /**Retourne une commande du fournisseur**/
//    public function getOrder($idOrder)
//    {
//        $db = Database::getInstance();
//       $db->query("SELECT username FROM Order WHERE fkidSupplier = ? AND idOrder = ?", array(this, $idUser));
////        $req = $db->prepare('SELECT  FROM Order WHERE fkidSupplier = ? AND idOrder = ?');
////        $req ->execute(array(this, $idUser));
//    }


    /**Supprime tous les clients du fournisseur**/
    //À voir si c'est pertinent ?
    public function deleteAllClient()
    {
        //supprimer tous les clients ayant le fournisseur X
        // penser au cas où un client a plusieurs fournisseurs
        $db = Database::getInstance();
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? ", array(this));

//        $req = $db->prepare('DELETE from Client WHERE fkidSupplier=?');
//        $req ->execute(array(this));


    }

    /**Supprime un client du fournisseur**/
    public function deleteClient($idAbout)
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? AND idClient=?", array(this,$idAbout));
        /*
         * penser à supprimer aussi les commandes => ATTENDRE BASE DE DONNÉES POUR ORDER
         * $db = Database::getInstance();
         * $db->query("DELETE FROM Order WHERE fkidSupplier = ? AND idClient=?", array(this,$idAbout));
         * penser à supprimer l'idClient dans la table supplier
         * */
//        $req = $db->prepare('DELETE from Client WHERE fkidSupplier=? AND idClient=?');
//        $req ->execute(array(this,$idAbout));

    }

    //à voir si c'est pertinent ?
    public function deleteAllProduct()
    {

    }

    public function deleteProduct($idAbout)
    {
        //Supprimer le produit de la table produit
        $db = Database::getInstance();
        $db->query("DELETE FROM Produit WHERE fkidSupplier = ? AND idProduit=?", array(this,$idAbout));

//        $req = $db->prepare('DELETE from Produit WHERE fkidSupplier=? AND idProduit=?');
//        $req ->execute(array(this,$idAbout));


    }

    //à voir si c'est pertinent ?
    public function deleteAllUser()
    {

    }

    public function deleteUser($idAbout)
    {

        $db = Database::getInstance();
        $db->query("DELETE FROM User WHERE fkidSupplier = ? AND id=? ", array(this,$idAbout));

//        $req = $db->prepare('DELETE from User WHERE fkidSupplier=? AND id=?');
//        $req ->execute(array(this,$idAbout));


    }

}
