<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 2019-03-11
 * Time: 21:04
 */

class Order
{
    private $_id;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    public function loadFromDB ()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Order WHERE id = ?", ['id', $this->_id]);
    }

    /**Ajouter une commande à un fournisseur**/
    public function addOrder($idSupplier)
    {
        $db = Database::insert();
        //$db->query("SELECT * FROM Supplier WHERE id = ?", ['id', $this->_id]);

    }

    public function compareOrder($id)
    {

    }

    public function itemsListOrder()
    {

    }

    public function updateOrder($id)
    {

    }

    public function deleteOrder($id) {

    }

}