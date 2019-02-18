<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-18
 * Time: 00:27
 */

class SupplierClientsList
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

        $this->_db->query('Select * FROM Client WHERE fkidSupplier = ?', array($supplierId));
        $this->_data = $this->_db->results();
    }

    public function getDB()
    {
        return $this->_db;
    }
    public function getResults()
    {
        $this->_db->results();
    }
    public function data(){
        return $this->_data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->_db->results();
    }

    public function getJSON()
    {
        $rows = array();
        $res = array();
        while ($row = $this->_data->fetch(PDO::FETCH_ASSOC)){
            $res [] = array(
                'idClient' => $row['idClient'],
                'nom' => $row['nom'],
                'courriel' => $row['courriel'],
                'condition_achat' => $row['condition_achat'],
                'adresseFacturation' => $row['adresseFacturation'],
                'adresseLivraison' => $row['adresseLivraison'],
                'fkidSupplier' => $row['fkidSupplier']

            );
            array_push($rows, $res);
        };
        return $rows;
    }

    public  function __destruct()
    {
        // TODO: Implement __destruct() method.
    }


}