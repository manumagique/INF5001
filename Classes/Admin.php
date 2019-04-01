<?php
/**
 * Created by PhpStorm.
 * User: jade
 * Date: 2019-02-18
 * Time: 00:27
 */
class Supplier
{
    private $_id;


    public function __construct()
    {

    }


    /** GET **/

    /**Retourne la liste des clients **/
    public function getClientList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client");
        return $db->resultsToJson();

    }

    /**Retourne la fiche détaillée d'un client **/
    public function getClient($idClient)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE idClient = ?", array($idClient));
        return $db->resultsToJson();

    }

    /**Retourne la liste des produits**/
    public function getProductList()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Product");
        return $db->resultsToJson();

    }

    /**Retourne le détail d'un produit**/
    public function getProduct($idProduct)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Product WHERE idProduct = ?", array($idProduct));
        return $db->resultsToJson();

    }

    /**Retourne la liste des utilisateurs **/
    public function getUserList()
    {
        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users");
        return $db->resultsToJson();

    }

    /**Retourne un utilisateur **/
    public function getUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users WHERE id = ?", array($idUser));
        return $db->resultsToJson();

    }

    /**Retourne la liste des commandes**/
    public function getOrderList()
    {
        $db = Database::getInstance();
        $db->query("SELECT id.ClientOrder, date.ClientOrder, user.ClientOrder, commentaire.ClientOrder, 
                  status.ClientOrder, fkidClient.ClientOrder, fkidSupplier.ClientOrder, nom.Client  
                  FROM ClientOrder INNER JOIN Client ON id.ClientOrder=idClient.Client ");
        return $db->resultsToJson();

    }

    /**Retourne une commande**/
    public function getOrder($idOrder)
    {
        $db = Database::getInstance();
        $db->query("SELECT id.ClientOrder, date.ClientOrder, user.ClientOrder, commentaire.ClientOrder, 
                  status.ClientOrder, fkidClient.ClientOrder, fkidSupplier.ClientOrder, nom.Client  
                  FROM ClientOrder INNER JOIN Client ON id.ClientOrder=idClient.Client WHERE id.ClientOrder = ?", array( $idOrder));
        return $db->resultsToJson();

    }

    /**POST**/

    public function addClient($data)
    {
        $db = Database::getInstance();
        //select count no de l'attribut id dans une variable
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'nom' => $data->name,
            'compagnie' => $data->compagny,
            'courriel' => $data->email,
            'condition_achat' => $data->buy_condition,
            'adresseFacturation' => $data->rec_adress,
            'adresseLivraison' => $data->ship_adress,
            'logo' => $data->logo,
            'nb_commande' => 0,
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

        $db->insert(Product, $fields);
    }

    /**
     */
    //TODO: UserCat ???
    //TODO: Vérifier userCat et salt => Emmanuel
    public function addUser($data)
    {

        $db = Database::getInstance();
        //$hash =
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'username' => $data->username,
            'password' => $data ->password,
            'userCat' => "Fournisseur",
            'fkidSupplier' => $data ->fkidSupplier,
            'fkidClient' => $data ->fkidClient,
        );
        $db->insert(User, $fields);
    }

    /**
     *Comment récupérer le fkidClient ?
     * Est-il donné par olivier ?
     **/
    //TODO: id=numero_commade ? oui,  user=client? oui
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
            'fkidSupplier' => $data ->fkidSupplier
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

    public function editClient($data, $idClient)
    {
        $db = Database::getInstance();
        $nb_commande = $db -> query("SELECT COUNT(id) FROM ClientOrder WHERE fkidSupplier = ? AND idClient = ?", array($this->_id,$idClient));
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'nom' => $data->name,
            'compagnie' => $data->compagny,
            'courriel' => $data->email,
            'condition_achat' => $data->buy_condition,
            'adresseFacturation' => $data->rec_adress,
            'adresseLivraison' => $data->ship_adress,
            'logo' => $data->logo,
            'nb_commande' => $nb_commande,
            'fkidSupplier' => $data->fkidSupplier
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
        $db->query("UPDATE Product SET $fields WHERE idProduct = ?", array($idProduct));
    }

    //TODO: Vérifier userCat et salt => Emmanuel
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
        $db->query("UPDATE oauth_users SET $fields WHERE id = ?", array($idUser));
    }

    //TODO: id=numero_commade ? oui user=client? oui
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

    /**Supprime tous les clients **/
    // deletera en cascade => Emmanuel
    public function deleteAllClient()
    {
        //supprimer tous les clients ayant le fournisseur X
        $db = Database::getInstance();
        /**Supprimer les clients **/
        $db->query("DELETE FROM Client ");
    }

    /**Supprime un client **/
    // deletera en cascade => Emmanuel
    public function deleteClient($idAbout)
    {
        $db = Database::getInstance();
        /**Supprimer le client**/
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? AND idClient=?", array($this->_id,$idAbout));

    }

    public function deleteAllProduct()
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? ", array($this->_id));

    }

    public function deleteProduct($idAbout)
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? AND idProduct=?", array($this->_id,$idAbout));

    }


    public function deleteAllUser()
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM oauth_users WHERE fkidSupplier = ? ", array($this->_id));
    }

    public function deleteUser($idAbout)
    {

        $db = Database::getInstance();
        $db->query("DELETE FROM oauth_users WHERE fkidSupplier = ? AND id=? ", array($this->_id,$idAbout));
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
