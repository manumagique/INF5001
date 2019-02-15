<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-12
 * Time: 12:42 PM
 */

class Database
{
    private static $_instance = NULL;

    private $host = "69.28.199.20";  //PDO HOST
    private $db_name = "lango721_gestiondecommandes";
    private $usename = "lango721_inm5001";
    private $password = "?h17b+gplF;H";
    private $socket_type = "mysql";

    private $_db = null;
    private $_querry;
    private $_error = false;
    private $_results;
    private $_count;

    private function __construct()
    {
        try
            {
                $this->_db = new PDO(
                    ''. $this->socket_type.':host='. $this->host. ';dbname='. $this->db_name .'', $this->usename, $this->password
                );
            }
            catch (PDOException $e)
            {
                die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance))
        {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_querry = $this->_db->prepare($sql))
        {
            if (count($params))
            {
                $i = 1;
                foreach ($params as $param)
                {
                    $this->_querry->bindValue($i, $param);
                    $i++;
                }
            }
           if ($this-> _querry->execute())
           {
               $this->_results = $this->_querry->fetchAll(PDO::FETCH_OBJ);
//               $this->_results = $this->_querry->fetchAll(SQLSRV_FETCH_ASSOC);
               $this->_count = $this->_querry->rowCount();
           }
           else
           {
               $this->_error = true;
           }
        }

        return $this;
    }

    public function toJson ()
    {
        json_encode($this->_results);
    }

    public function action($action, $table, $where = array())
    {
        if (count($where) === 3)
        {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators))
            {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value)))
                {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table, $where )
    {
        return $this->_action('SELECT *', $table, $where );
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE' , $table, $where);
    }

    public function insert($table, $fields)
    {
            $keys = array_keys($fields);
            $values = '';
            $x = 1;

            foreach ($fields as $field)
            {
                $values .= '?';
                if ($x < count($fields))
                {
                    $values .= ', ';
                }
                $x++;
            }

            $sql = "INSERT INTO {$table}  (`" . implode('`,`', $keys) . "`) VALUES ({$values})";
            if (!$this->query($sql, $fields)->error())
            {
                return true;
            }

            return false;
    }

    public function update($table, $id, $fields )
    {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $values)
        {
            $set .= "{$name} = ?";
            if ($x < count($fields))
            {
                $set .=', ';
            }
            $x++ ;
        }
        
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if (!$this->query($sql, $fields)->error())
        {
            return true;
        }
        return false;
    }

    public function results()
    {
        return $this->_results;
    }

    public function firstRecord()
    {
        return $this->results()[0];
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }

//    private function __destruct()
//    {
//        // TODO: Implement __destruct() method Database.
//    }
}