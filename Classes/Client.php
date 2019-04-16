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

    public function getClientDetails() {

        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE idClient = ?", array($this->_id));
        return $db->resultsToJson();

    }

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

    public function getUsersList() {

        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users WHERE fkidClient = ?", array($this->_id));
        return $db->resultsToJson();

    }

    public function getUser($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT id, username FROM oauth_users WHERE fkidClient = ? AND id = ?", array($this->_id, $idAbout));
        return $db->resultsToJson();

    }

    public function getOrdersList() {

        $db = Database::getInstance();
        $db->query("SELECT * FROM ClientOrder WHERE fkidClient = ? ", array($this->_id));
        return $db->resultsToJson();

    }

    public function getOrder($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT * FROM ClientOrder WHERE fkidClient = ? AND id = ?", array($this->_id, $idAbout));
        return $db->resultsToJson();

    }

    /* méthodes pour POST */

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

        $db->insert('oauth_users', $fields);
    }

    public function addOrder($data) {

        $db = Database::getInstance();

        $fields = array(
            'date' => $data->date,
            'user' => $data ->user,
            'commentaire' => $data ->commentaire,
            'status' => "0",
            'fkidClient' => $data->fkidClient,
            'fkidSupplier' => $data ->fkidSupplier,
        );

        $db->insert('ClientOrder', $fields);

        $products = $data->produits;

        foreach($products as $champ) {
            $fields2 = array(
                'fkidProduct' => $champ->fkidProduct,
                'Qty' => $champ->Qty,
                'fkid_ClientOrder' => $champ->fkid_ClientOrder
            );

            $db->insert('clientOrderDetail', $fields2);

        }

    }

    /* méthodes pour PUT */

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

        $db->update('oauth_users', $idAbout, $field);
    }

    public function updateOrder($data, $idAbout) {

        $db = Database::getInstance();

        $products = array();

        $field = array();
        foreach ($data as $key => $value) {
            $fields = array (
                $key => $value
            );

            $field = $field + $fields;
        }

        $db->update('ClientOrder', $idAbout, $field);


        //$fields = array(
        //    'date' => $data->date,
        //    'commentaire' => $data->commentaire,
        //    'status' => $data->status
        //);

    }


    /* méthodes pour DELETE */

    public function deleteAllProducts() {

        $db = Database::getInstance();

        $clientSupplier = $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? ", array($clientSupplier));

    }

    public function deleteProduct($idAbout) {

        $db = Database::getInstance();
        $clientSupplier = $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($clientSupplier, $idAbout));

    }

    public function deleteAllUsers() {

        $db = Database::getInstance();
        $db->query("DELETE FROM oauth_users WHERE fkidClient = ? ", array($this->_id));

    }

    public function deleteUser($idAbout) {

        $db = Database::getInstance();
        $db->query("DELETE FROM oauth_users WHERE fkidClient = ? AND id = ? ", array($this->_id, $idAbout));

    }

    public function deleteAllOrders() {

        $db = Database::getInstance();
        $db->query("DELETE FROM ClientOrder WHERE fkidClient = ? ", array($this->_id));

    }

    public function deleteOrder($idAbout) {

        $db = Database::getInstance();
        $db->query("DELETE FROM ClientOrder WHERE fkidClient = ? AND id = ? ", array($this->_id, $idAbout));
    }
}