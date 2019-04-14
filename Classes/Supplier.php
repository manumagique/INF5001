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
        $db->query("SELECT id, username FROM oauth_users WHERE fkidSupplier = ?", array($this->_id));
        return $db->resultsToJson();

    }

    /**Retourne un utilisateur du fournisseur**/
    public function getUser($idUser)
    {
        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users WHERE fkidSupplier = ? AND id = ?", array($this->_id, $idUser));
        return $db->resultsToJson();

    }

    /**Retourne la liste des commandes du fournisseur**/
    public function getOrderList()
    {
        $db = Database::getInstance();
        $db->query("SELECT id.ClientOrder, date.ClientOrder, user.ClientOrder, commentaire.ClientOrder, 
                  status.ClientOrder, fkidClient.ClientOrder, fkidSupplier.ClientOrder, nom.Client  
                  FROM ClientOrder INNER JOIN Client ON id.ClientOrder=idClient.Client WHERE fkidSupplier.ClientOrder = ? ", array($this->_id));
        return $db->resultsToJson();

    }

    /**Retourne une commande du fournisseur**/
    public function getOrder($idOrder)
    {
        $db = Database::getInstance();
        $db->query("SELECT id.ClientOrder, date.ClientOrder, user.ClientOrder, commentaire.ClientOrder, 
                  status.ClientOrder, fkidClient.ClientOrder, fkidSupplier.ClientOrder, nom.Client  
                  FROM ClientOrder INNER JOIN Client ON id.ClientOrder=idClient.Client WHERE fkidSupplier.ClientOrder = ? AND id.ClientOrder = ?", array($this->_id, $idOrder));
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

    /**Ici je fais comme s'il n'y avait pas de fkidClient puisque
     * c'est un utilisateur du fournisseur
     */
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
            'fkidSupplier' => $this->_id
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
        $Produits=array();
        $ProduitsList=array();
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'date' => date_default_timezone_set('UTC'),
            'user' => $db -> query("SELECT nom FROM Client WHERE fkidSupplier = ? AND idClient = ?", array($this->_id,$data ->fkidClient)),
            'commentaire' => $data ->commentaire,
            'status' => "0",
            'fkidClient' => $data ->fkidClient,
            'fkidSupplier' => $this->_id,
            $Produits => $data->produit
        );

        foreach( $Produits as $champ){
            $fieldsProd = array(
                'fkidProduct' => $Produits -> fkidProduct,
                'Qty' => $Produits -> quantite,
                'fkid_ClientOrder' => $data ->fkidClient,
                'name' => $db -> query("SELECT nom FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($this->_id,$Produits -> fkidProduct))

        );
            array_push($ProduitsList, $fieldsProd);
        }
        $db->insert(ClientOrder, $fields);
        $db->insert(clientOrderDetail, $ProduitsList);
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
        $Produits=array();
        $ProduitsList=array();
        $db = Database::getInstance();
        $fields = array(
            // en premier nom ds la table et a la fin nom de olivier
            'date' => date_default_timezone_set('UTC'),
            'id' => $data->numero_commande,
            'user' => $db -> query("SELECT nom FROM Client WHERE fkidSupplier = ? AND idClient = ?", array($this->_id,$data ->fkidClient)),
            'commentaire' => $data ->commentaire,
            'status' => $data ->done,
            'fkidClient' => $data ->fkidClient,
            'fkidSupplier' => $this->_id,
            $Produits => $data->produit
        );

        foreach( $Produits as $champ){
            $fieldsProd = array(
                'fkidProduct' => $Produits -> fkidProduct,
                'Qty' => $Produits -> quantite,
                'fkid_ClientOrder' => $data ->fkidClient,
                'name' => $db -> query("SELECT nom FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($this->_id,$Produits -> fkidProduct))

            );
            array_push($ProduitsList, $fieldsProd);
        }
        $db->query("UPDATE ClientOrder SET $fields WHERE idOrder = ?", array($idOrder));
        $db->query("UPDATE clientOrderDetail SET $ProduitsList WHERE idOrder = ?", array($idOrder));
    }


    /**DELETE**/

    /**Supprime tous les clients du fournisseur**/
    // deletera en cascade => Emmanuel
    public function deleteAllClient()
    {
        //supprimer tous les clients ayant le fournisseur X
        $db = Database::getInstance();
        /**Supprimer les clients **/
        $db->query("DELETE FROM Client WHERE fkidSupplier = ? ", array($this->_id));
    }

    /**Supprime un client du fournisseur**/
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
