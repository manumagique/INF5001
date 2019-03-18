<?php

/*CETTE PAGE DEVRAIT ETRE SUPPRIMER -> NE SERT À RIEN SELON JADE*/

///**
// * Created by PhpStorm.
// * User: emmanuelboyer
// * Date: 2019-02-18
// * Time: 00:27
// */
//
//class SupplierClients
//{
//    private $_supplierId,
//        $_data,
//        $_sessionName,
//        $_db;
//
//    public function __construct($supplierId)
//    {
//        $this->_db = Database::getInstance();
//        $this->_sessionName = Config::get('session/session_name');
//        $this->_supplierId = $supplierId;
//
//        $this->_db->query('Select * FROM Client WHERE fkidSupplier = ?', array($supplierId));
//        $this->_data = $this->_db->resultsToJson();
//    }
//
//    public function data(){
//        return $this->_data;
//    }
//
//    public  function __destruct()
//    {
//        // TODO: Implement __destruct() method.
//    }
//
//
//}