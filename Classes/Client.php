<?php
/**Jade Pomerleau Gauthier*/

/**
 * Author: Valentina
 * Date: Winter 2019
 */

class Client
{
    private $_id;

    public function __construct($id)
    {
        $this->_id = $id;
    }

    /* méthodes pour GET */

    /* ------ GET details Client ------ */
    public function getClientDetails() {

        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE idClient = ?", array($this->_id));
        return $db->resultsToJson();

    }

    /* ------ GET liste des produits du fournisseur rattache au Client ------ */
    public function getProductsList() {

        $db = Database::getInstance();
        $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));

        $_data = $db->results();
        foreach ($_data as $row)
        {
            $clientSupplier = $row->fkidSupplier;
        }

        $db->query("SELECT * FROM Product WHERE fkidSupplier = ?", array($clientSupplier));

        return $db->resultsToJson();

    }

    /* ------ GET la fiche detaille d'un produit du fournisseur rattache au Client ------ */
    public function getProductDetails($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));

        $_data = $db->results();
        foreach ($_data as $row)
        {
            $clientSupplier = $row->fkidSupplier;
        }

        $db->query("SELECT * FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($clientSupplier, $idAbout));
        return $db->resultsToJson();

    }

    /* ------ GET liste des utilisateurs du Client ------ */
    public function getUsersList() {

        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users WHERE fkidClient = ?", array($this->_id));
        return $db->resultsToJson();

    }

    /* ------ GET details d'un utilisateur du Client ------ */
    public function getUser($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users WHERE fkidClient = ? AND id = ?", array($this->_id, $idAbout));
        return $db->resultsToJson();

    }

    /* ------ GET liste des commandes du Client ------ */
    public function getOrdersList() {

        //$db = Database::getInstance();
        //$db->query("SELECT * FROM ClientOrder WHERE fkidClient = ? ", array($this->_id));
        //return $db->resultsToJson();

        $db = Database::getInstance();
        $db->query("SELECT ClientOrder.id, ClientOrder.date, ClientOrder.user, ClientOrder.commentaire, 
       ClientOrder.status, ClientOrder.fkidClient, ClientOrder.fkidSupplier, clientOrderDetail.Qty, 
       Product.idProduct, Product.nom, Product.prix, Product.description, Product.origine, Product.code, Product.format, Product.fkidSupplier
                  FROM ClientOrder 
                    INNER JOIN clientOrderDetail ON ClientOrder.id = clientOrderDetail.fkid_ClientOrder
                      INNER JOIN Product ON Product.idProduct = clientOrderDetail.fkidProduct
                        WHERE ClientOrder.fkidClient = ? ", array($this->_id));

        return $db->resultsToJson();

    }

    /* ------ GET details d'une commande du Client ------ */
    public function getOrder($idAbout) {

        //$db = Database::getInstance();
        //$db->query("SELECT * FROM ClientOrder WHERE fkidClient = ? AND id = ?", array($this->_id, $idAbout));
        //return $db->resultsToJson();

        $db = Database::getInstance();
        $db->query("SELECT ClientOrder.id, ClientOrder.date, ClientOrder.user, ClientOrder.commentaire, 
       ClientOrder.status, ClientOrder.fkidClient, ClientOrder.fkidSupplier, clientOrderDetail.Qty, 
       Product.idProduct, Product.nom, Product.prix, Product.description, Product.origine, Product.code, Product.format, Product.fkidSupplier
                  FROM ClientOrder 
                    INNER JOIN clientOrderDetail ON ClientOrder.id = clientOrderDetail.fkid_ClientOrder
                      INNER JOIN Product ON Product.idProduct = clientOrderDetail.fkidProduct
                        WHERE ClientOrder.fkidClient = ? AND id = ?", array($this->_id, $idAbout));

        return $db->resultsToJson();

    }

    /* méthodes pour POST */

    /* ------ POST ajout details d'un utilisateur du Client ------ */
    public function addUser($data) {

        $db = Database::getInstance();

        $hashpwd = hashPassword($data->password);

        $fields = array(
            'username' => $data->username,
            'password' => $hashpwd,
//            'salt' => Hash::unique(),
            'userCat' => "Client",
            'fkidClient' => $data->fkidClient,
//            'first_name' => $data->first_name,
//            'last_name' => $data->last_name,
//            'email' => $data->email,
//            'email_verified' => $data->email_verified,
//            'scope' => $data->scope
        );

        $res = $db->insert('oauth_users', $fields);

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }
    }

    /* ------ POST ajout details d'une commande du Client ------ */
    public function addOrder($data) {

        $db = Database::getInstance();

        $dateTime = date("Y-m-d");      //date("d/m/Y");

        $fields = array(
            'date' => $dateTime,
            'user' => $data->user,
            'commentaire' => $data->commentaire,
            'status' => "0",
            'fkidClient' => $data->fkidClient,
            'fkidSupplier' => $data ->fkidSupplier,
        );

        $res = $db->insert('ClientOrder', $fields);

        if($res)
        {
            $db->query("SELECT id FROM ClientOrder WHERE date = ? AND user = ? 
                             AND commentaire = ? AND status = ? AND fkidClient = ? 
                             AND fkidSupplier = ?", array($dateTime, $data->user, $data->commentaire, "0",
                $data->fkidClient, $data ->fkidSupplier));

            $_data = $db->results();
            foreach ($_data as $row)
            {
                $idOrder = $row->id;
            }

            $products = $data->produits;

            foreach($products as $champ) {
                $fields2 = array(
                    'fkidProduct' => $champ->fkidProduct,
                    'Qty' => $champ->Qty,
                    'fkid_ClientOrder' => $idOrder
                );

                $res = $db->insert('clientOrderDetail', $fields2);

            }

            if($res)
            {
                return "Success";
            }
            else
            {
                return "Error";

            }

        }
        else
        {
            return "Error";

        }



    }

    /* méthodes pour PUT */

    /* ------ PUT mise à jour details d'un utilisateur du Client ------ */
    public function updateUser($data, $idAbout) {

        $db = Database::getInstance();

        $field = array();
        foreach ($data as $key => $value) {
            $fields = array (
                $key => $value
            );

            $field = $field + $fields;
        }

        //$fields = array(
        //    'username' => $data->username,
        //    'password' => $data ->password,
        //    'first_name' => $data->first_name,
        //    'last_name' => $data->last_name,
        //    'email' => $data->email
        //);

        $res = $db->update('oauth_users', $idAbout, $field);

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }
    }

    /* ------ PUT mise à jour details d'une commande du Client ------ */
    public function updateOrder($data, $idAbout) {

        $db = Database::getInstance();

        //$products = array();

        $field = array();
        foreach ($data as $key => $value) {
            $fields = array (
                $key => $value
            );

            $field = $field + $fields;
        }

        $res = $db->update('ClientOrder', $idAbout, $field);

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }


        //$fields = array(
        //    'date' => $data->date,
        //    'commentaire' => $data->commentaire,
        //    'status' => $data->status
        //);

    }


    /* méthodes pour DELETE */

    /* ------ DELETE les utilisateurs du Client ------ */
    public function deleteAllUsers() {

        $db = Database::getInstance();
        $res = $db->query("DELETE FROM oauth_users WHERE fkidClient = ? ", array($this->_id));

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }

    }

    /* ------ DELETE un utilisateur du Client ------ */
    public function deleteUser($idAbout) {

        $db = Database::getInstance();
        $res = $db->query("DELETE FROM oauth_users WHERE fkidClient = ? AND id = ? ", array($this->_id, $idAbout));

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }

    }

    /* ------ DELETE les commandes du Client ------ */
    public function deleteAllOrders() {

        $db = Database::getInstance();
        $res = $db->query("DELETE FROM ClientOrder WHERE fkidClient = ? ", array($this->_id));

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }

    }

    /* ------ DELETE une commande du Client ------ */
    public function deleteOrder($idAbout) {

        $db = Database::getInstance();
        $res = $db->query("DELETE FROM ClientOrder WHERE fkidClient = ? AND id = ? ", array($this->_id, $idAbout));

        if($res)
        {
            return "Success";
        }
        else
        {
            return "Error";

        }
    }
}
