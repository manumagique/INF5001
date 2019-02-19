<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-19
 * Time: 01:30
 */

class ClientUsersList
{
    private $_clientId,
        $_data,
        $_sessionName,
        $_db;

    public function __construct($clientId)
    {
        $this->_db = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_clientId = $clientId;

        $this->_db->query('Select id, username, userCat FROM User WHERE fkidClient = ?', array($clientId));
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