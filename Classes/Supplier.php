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
        $db->query("SELECT * FROM Client WHERE fkidSupplier = ?", array($this->_id));
        return $db->resultsToJson();

    }

    /**Retourne la fiche détaillée d'un client  du fournisseur**/
    public function getClient($idClient)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE fkidSupplier = ? AND idClient = ?", array($this->_id,$idClient));
        return $db->resultsToJson();

    }

    /**Retourne la liste des produits du fournisseur**/
    public function getProductList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Product WHERE fkidSupplier = ?", array($this->_id));
        return $db->resultsToJson();

    }

    /**Retourne le détail d'un produit du fournisseur**/
    public function getProduct($idProduct)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($this->_id, $idProduct));
        return $db->resultsToJson();

    }

    /**Retourne la liste des utilisateurs du fournisseur**/
    public function getUserList()
    {
        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidSupplier = ?", array($this->_id));
        return $db->resultsToJson();

    }

    /**Retourne un utilisateur du fournisseur**/
    public function getUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidSupplier = ? AND id = ?", array($this->_id, $idUser));
        return $db->resultsToJson();

    }

    /**ATTENDRE TABLE BASE DE DONNÉES COMMANDE **/
    /**Retourne la liste des commandes du fournisseur**/
    public function getOrderList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM ClientOrder WHERE fkidSupplier = ? ", array($this->_id));
        return $db->resultsToJson();

    }

    /**Retourne une commande du fournisseur**/
    public function getOrder($idOrder)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM ClientOrder WHERE fkidSupplier = ? AND id = ?", array($this->_id, $idOrder));
        return $db->resultsToJson();

    }

    /**POST**/

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
            'fkidSupplier' => $this->_id
        );

        $db->insert(Client, $fields);

    }

    public function addProduct($data)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'nom' => $data->name,
            'logo' => $data ->logo,
            'prix' => $data->price,
            'description' => $data->description,
            'orgine' => $data->origine,
            'code' => $data->code,
            'format' => $data->format,
            // n'est pas dans les champs envoyé par olivier J'ai donc fait ceci-ci: pas sur
            'fkidSupplier' => $this->_id
        );

        $db->insert(Produit, $fields);
    }

    public function addUser($data)
    {
        $db = Database::getInstance();
        $db->insert(User, array());
    }

    public function addOrder($data)
    {
        $db = Database::getInstance();
        $db->insert(ClientOrder, array());
    }


    /**PUT**/
    //$data: key-value des nouvelle valeurs
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
            'fkidSupplier' => $this->_id
        );

        $db->query("UPDATE Client SET $fields WHERE idClient = ?", array($idClient));

    }

    public function editProduct($data, $idProduct)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'nom' => $data->name,
            'logo' => $data ->logo,
            'prix' => $data->price,
            'description' => $data->description,
            'orgine' => $data->origine,
            'code' => $data->code,
            'format' => $data->format,
            // n'est pas dans les champs envoyé par olivier J'ai donc fait ceci-ci: pas sur
            'fkidSupplier' => $this->_id
        );
        $db->query("UPDATE Produit SET $fields WHERE idProduit = ?", array($idProduct));
    }

    public function editUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("UPDATE User SET WHERE id = ?", array($idUser));
    }

    public function editOrder($idOrder)
    {
        $db = Database::getInstance();
        $db->query("UPDATE ClientOrder SET WHERE idOrder = ?", array($idOrder));
    }


    /**DELETE**/

    /**Supprime tous les clients du fournisseur**/
    public function deleteAllClient()
    {
        //supprimer tous les clients ayant le fournisseur X
        $db = Database::getInstance();
        /**Supprimer les clients **/
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? ", array($this->_id));
        /**Supprimer les commandes des clients
         *Est-ce qu'on voudrait les garder dans la BD quand même ? **/
        $db->query("DELETE FROM ClientOrder WHERE fkidSupplier = ? ", array($this->_id));
        /**Supprimer les users des clients **/
        $db->query("DELETE FROM User WHERE fkidSupplier = ? ", array($this->_id));

    }

    /**Supprime un client du fournisseur**/
    public function deleteClient($idAbout)
    {
        $db = Database::getInstance();
        /**Supprimer le client**/
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? AND idClient=?", array($this->_id,$idAbout));

        /**Supprimer les commandes du client**/
        $db->query("DELETE FROM ClientOrder WHERE fkidSupplier = ? AND idClient=?", array($this->_id,$idAbout));

        /**Supprimer les users du client**/
        $db->query("DELETE FROM User WHERE fkidSupplier = ? AND fkidClient=?", array($this->_id,$idAbout));


    }

    public function deleteAllProduct()
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? ", array($this->_id));

    }

    public function deleteProduct($idAbout)
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM Produit WHERE fkidSupplier = ? AND idProduit=?", array($this->_id,$idAbout));

    }


    public function deleteAllUser()
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM User WHERE fkidSupplier = ? ", array($this->_id));
    }

    public function deleteUser($idAbout)
    {

        $db = Database::getInstance();
        $db->query("DELETE FROM User WHERE fkidSupplier = ? AND id=? ", array($this->_id,$idAbout));
    }

    public function deleteAllOrder()
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM ClientOrder WHERE fkidSupplier = ? ", array($this->_id));
    }

    public function deleteOrder($idAbout)
    {

        $db = Database::getInstance();
        $db->query("DELETE FROM ClientOrder WHERE fkidSupplier = ? AND id=? ", array($this->_id,$idAbout));
    }
}
