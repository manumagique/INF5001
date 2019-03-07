<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-18
 * Time: 00:27
 */

class Supplier
{
    private $_id;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    public function loadFromDB ()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Supplier WHERE id = ?", ['id', $this->_id]);
    }

    public function getClientList()
    {
        echo "prout prout";
    }

}