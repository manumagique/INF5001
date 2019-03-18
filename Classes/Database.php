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

    private $_PDO = null;
    private $_query;
    private $_error = false;
    private $_results = array();
    private $_count = 0;

    /*Connexion à la base de données*/
    private function __construct()
    {
        try
        {
            $this->_PDO = new PDO(
                ''. $this->socket_type.':host='. $this->host. ';dbname='. $this->db_name .'', $this->usename, $this->password
            );
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

    /*Connexion à la base de données*/
    public static function getInstance()
    {
        if (!isset(self::$_instance))
        {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    /*
     * Effectuer un action sur la base de données
     *
     * $sql: la requête ex: "SELECT * FROM Client WHERE id = ?"
     * $params : les conditions de recherche
     * */
    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_PDO->prepare($sql))
        {
            $i = 1;
            if (count($params))
            {
                foreach ($params as $param)
                {
                    $this->_query->bindValue($i, $param);
                    $i++;
                }
            }
            if ($this-> _query->execute())
            {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }
            else
            {

                $this->_error = true;
            }
        }

        return $this;
    }

    /*
     * Effectuer un action sur la base de données
     *
     * $action: L'action qu'on veut effectuer ex: SELECT, DELETE, INSERT
     * $table: le nom de la table dans la base de données
     * $where: tableau des conditions de recherche ex:
     *
     * N'est pas vrm utilisé dans nos classes
     * */
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
                if (!$this->query($sql, array($value))->error())
                {
                    return $this;
                }
            }
        }
        return false;
    }

    /*
     * Retourner (SELECT) tous les attributs (*) d'un élément d'une table ($table)
     *
     * $table: le nom de la table de la base de données
     * $where: la condition ex: WHERE idClient=2
     * */
    public function get($table, $where )
    {
        return $this->action('SELECT *', $table, $where );
    }

    /*
     * Supprimer (DELETE) un élément d'une table ($table)
     *
     * $table: le nom de la table de la base de données
     * $where: la condition ex: WHERE idClient=2
     * */
    public function delete($table, $where)
    {
        return $this->action('DELETE' , $table, $where);
    }

    /*
     * Ajouter une entité à la base de données
     *
     * $table: le nom de la table dans la base de données où on veut ajouter l'élément
     * $fields: l'array des éléments à ajouter
     * */
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

    /*
     * Mettre à jour une entité dans la base de données
     *
     * $table: le nom de la table dans la base de données où se trouve l'élément (entité)
     * $id: l'id de l'élément modifier
     * $fields: l'array des éléments à modifier
     *
     * */
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

    /*
     * Ne sais pas ce que ca fait ..
     * */
    public function results()
    {
        return $this->_results;
    }

    /*
     * Retourner un Json
     */
    public function resultsToJson ()
    {
//        $res = array();
//        foreach ($this->results() as $result)
//        {
//            array_push($res, array($result));
//        }
        return json_encode($this->results());
    }

    /*
     * Ne sais pas
     * Peut-etre pour l'affichage d'Olivier on veut avoir le premier élément de la base de données ?
     * */
    public function firstRecord()
    {
        return $this->results()[0];
    }

    /*Message d'erreur */
    public function error()
    {
        return $this->_error;
    }

    /*
     * Compter le nombre d'éléments dans la base de données ??
     * => Je crois qu'olivier a dit que ca se faisait directement avec la base de données ?
     *  */
    public function count()
    {
        return $this->_count;
    }

    /*
     * Détruire une table de la base de données ?
     * Ne sais pas si c'est utile dans notre cas
     * */
//    private function __destruct()
//    {
//        // TODO: Implement __destruct() method Database.
//    }
}