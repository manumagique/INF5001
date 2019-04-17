<?php

require_once "Database.php";
class platformUser
{

    public function getUserInfo ($user)
    {
        $db = Database::getInstance();
        $res = $db->query("SELECT * FROM oauth_users WHERE username = ?", array($user));
        echo $res->resultsToJson();
    }

}