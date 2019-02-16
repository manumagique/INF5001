<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-12
 * Time: 3:20 PM
 */

class User
{
    private $_db;
    private $_data;
    private $_sessionName;
    private $_isLoggedIn;

    public function __construct($user = null )
    {
        $this->_db = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if ($user)
        {
            if (Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);

                if ($this->find($user))
                {
                    $this->_isLoggedIn = true;
                }
                else
                {
                    //process logout
                }
            }

        }
        else
        {
            $this->find($user);
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('Users', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer l''utilisateur");
        }
    }

    public function find($user = null)
    {
        if ($user)
        {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('User', array($field, '=', $user));
//            $data = $this->_db->query();

            if ($data->count())
            {
                 $this->_data =$data->firstRecord();
                 return true;
            }
        }

    }

    public function login($username = null, $password = null)
    {
        $user = $this->find($username);
        print_r($this->_data);

        if ($user)
        {
            if ($this->data()->password === Hash::make($password, $this->data()->salt))
            {
            Session::put($this->_sessionName, $this->data()->id);
            echo 'prout prout OK';
            }
        }
        return false;
    }
    public function logout()
    {
        Session::delete($this->_sessionName);
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
}