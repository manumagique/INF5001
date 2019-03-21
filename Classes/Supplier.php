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


    /** GET **/

    /**Retourne la liste des clients du fournisseur**/
    public function getClientList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE fkidSupplier = ?", array(this));
        return $db->resultsToJson();

    }

    /**Retourne la fiche détaillée d'un client  du fournisseur**/
    public function getClient($idClient)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE fkidSupplier = ? AND idClient = ?", array(this,$idClient));
        return $db->resultsToJson();

    }

    /**Retourne la liste des produits du fournisseur**/
    public function getProductList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Produit WHERE fkidSupplier = ?", array(this));
        return $db->resultsToJson();

    }

    /**Retourne le détail d'un produit du fournisseur**/
    public function getProduct($idProduct)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Produit WHERE fkidSupplier = ? AND idProduit = ?", array(this, $idProduct));
        return $db->resultsToJson();

    }

    /**Retourne la liste des utilisateurs du fournisseur**/
    public function getUserList()
    {
        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidSupplier = ?", array(this));
        return $db->resultsToJson();

    }

    /**Retourne d'un utilisateur du fournisseur**/
    public function getUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidSupplier = ? AND id = ?", array(this, $idUser));
        return $db->resultsToJson();

    }

    /**ATTENDRE TABLE BASE DE DONNÉES COMMANDE **/
    /**Retourne la liste des commandes du fournisseur**/
    public function getOrderList()
    {
       $db = Database::getInstance();
       $db->query("SELECT username FROM ClientOrder WHERE fkidSupplier = ? ", array(this));
        return $db->resultsToJson();

    }

    /**Retourne une commande du fournisseur**/
    public function getOrder($idOrder)
    {
        $db = Database::getInstance();
       $db->query("SELECT username FROM ClientOrder WHERE fkidSupplier = ? AND id = ?", array(this, $idOrder));
        return $db->resultsToJson();

    }

    /**POST**/
    // Comment on recoit l.info ?
    //Possible d'indiquer fkidSupplier ?
    public function addClient($data)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'nom' => $data->name,
            'compagnie' => $data->compagny,
            'courriel' => $data->email,
            'condition_achat' => $data->buy_condition,
            'adresseFacturation' => $data->rec_adress,
            'adresseLivraison' => $data->ship_adress,
            'logo' => $data->logo,
            //nb_commande ?! Le calculer -> Ne sais pas si ca doit etre un champs dans la base de données
            'nb_commande' => $data->nb_commande,
            // n'est pas dans les champs envoyé par olivier J'ai donc fait ceci-ci: pas sur
            'fkidSupplier' => this
        );

        $db->insert(Client, $fields);

    }

    public function addProduct()
    {
        $db = Database::getInstance();
        $data = json_decode(file_get_contents("php://input"));
        $db->insert(Produit, array());
    }

    public function addUser()
    {
        $db = Database::getInstance();
        $data = json_decode(file_get_contents("php://input"));
        $db->insert(User, array());
    }

    public function addOrder()
    {
        $db = Database::getInstance();
        $data = json_decode(file_get_contents("php://input"));
        $db->insert(Order, array());
    }


    /**PUT**/
    // Comment on recoit l.info ?
    //$array: key-value des nouvelle valeurs
    // ex :
    //          $query = "UPDATE
    //                " . $this->table_name . "
    //            SET
    //                name = :name,
    //                price = :price,
    //                description = :description,
    //                category_id = :category_id
    //            WHERE
    //                id = :id";

    public function editClient($data, $idClient)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'nom' => $data->name,
            'compagnie' => $data->compagny,
            'courriel' => $data->email,
            'condition_achat' => $data->buy_condition,
            'adresseFacturation' => $data->rec_adress,
            'adresseLivraison' => $data->ship_adress,
            'logo' => $data->logo,
            //nb_commande ?! Le calculer -> Ne sais pas si ca doit etre un champs dans la base de données
            'nb_commande' => $data->nb_commande,
            // n'est pas dans les champs envoyé par olivier J'ai donc fait ceci-ci: pas sur
            'fkidSupplier' => this
        );

        $db->query("UPDATE Client SET $fields WHERE idClient = ?", array($idClient));

    }

    public function editProduct($idProduct)
    {
        $db = Database::getInstance();
        $db->query("UPDATE Produit SET WHERE idProduit = ?", array($idProduct));
    }

    public function editUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("UPDATE User SET WHERE id = ?", array($idUser));
    }

    public function editOrder($idOrder)
    {
        $db = Database::getInstance();
        $db->query("UPDATE Order SET WHERE idOrder = ?", array($idOrder));
    }


    /**DELETE**/
    /**Supprime tous les clients du fournisseur**/
    //À voir si c'est pertinent ?
    public function deleteAllClient()
    {
        //supprimer tous les clients ayant le fournisseur X
        // penser au cas où un client a plusieurs fournisseurs
        $db = Database::getInstance();
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? ", array(this));

    }

    /**Supprime un client du fournisseur**/
    public function deleteClient($idAbout)
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? AND idClient=?", array(this,$idAbout));
        /**
         * penser à supprimer aussi les commandes => ATTENDRE BASE DE DONNÉES POUR ORDER
         * $db = Database::getInstance();
         * $db->query("DELETE FROM Order WHERE fkidSupplier = ? AND idClient=?", array(this,$idAbout));
         * penser à supprimer l'idClient dans la table supplier
         * **/
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
