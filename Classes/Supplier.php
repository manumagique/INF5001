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

    //TODO: calculer nb_commande
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
            'fkidSupplier' => $this->_id
        );

        $db->insert(Produit, $fields);
    }

    /**Ici je fais comme s'il n'y avait pas de fkidClient puisque
     * c'est un utilisateur du fournisseur
     *
     * Quel est le userCat ?
     * Est-ce qu'on met le salt ?
     */
    //TODO: Vérifier userCat et salt
    public function addUser($data)
    {

        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'username' => $data->username,
            'password' => $data ->password,
            'userCat' => "Fournisseur",
            'fkidSupplier' => $this->_id
        );
        $db->insert(User, $fields);
    }

    /**
    *Comment récupérer le fkidClient ?
     * Est-il donné par olivier ?
     **/
    //TODO:Modifier clé d'olivier dans fkidClient' => $data ->fkidClient
    //TODO: id=numero_commade ? user=client?
    //TODO: Lire les nom  quantité dans une boucle ? pour produit commandé
    public function addOrder($data)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'date' => $data->date_commande,
            'id' => $data->numero_commande,
            'user' => $data ->client,
            'commentaire' => $data ->commentaire,
            'status' => $data ->done,
            'fkidClient' => $data ->fkidClient,
            'fkidSupplier' => $this->_id
        );
        $db->insert(ClientOrder, $fields);
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

    //TODO: calculer nb_commande
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
            'fkidSupplier' => $this->_id
        );
        $db->query("UPDATE Produit SET $fields WHERE idProduit = ?", array($idProduct));
    }

    //TODO: Vérifier userCat et salt
    public function editUser($data, $idUser)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'username' => $data->username,
            'password' => $data ->password,
            'userCat' => "Fournisseur",
            'fkidSupplier' => $this->_id
        );
        $db->query("UPDATE User SET $fields WHERE id = ?", array($idUser));
    }

    //TODO:Modifier clé d'olivier dans fkidClient' => $data ->fkidClient
    //TODO: id=numero_commade ? user=client?
    //TODO: Lire les nom  quantité dans une boucle ? pour produit commandé
    public function editOrder($data, $idOrder)
    {
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'date' => $data->date_commande,
            'id' => $data->numero_commande,
            'user' => $data ->client,
            'commentaire' => $data ->commentaire,
            'status' => $data ->done,
            'fkidClient' => $data ->fkidClient,
            'fkidSupplier' => $this->_id
        );
        $db->query("UPDATE ClientOrder SET $fields WHERE idOrder = ?", array($idOrder));
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
