<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 00:03
 */

class SupplierProduitsList
{
    private $_supplierId,
        $_data,
        $_sessionName,
        $_db;

    public function __construct($supplierId)
    {
        $this->_db = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_supplierId = $supplierId;

        $this->_db->query('Select * FROM Produit WHERE fkidSupplier = ?', array($supplierId));
        $this->_data = $this->_db->resultsToJson();
    }

    public function data(){
        return $this->_data;
    }

    public  function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}