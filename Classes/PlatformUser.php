<?php

require_once "../oauth/server.php";
class platformUser extends \OAuth2\Storage\Pdo
{

public function setPlatformUser ($username, $password, $firstName = null, $lastName = null)
{
    $password = $this->hashPassword($password);

    // if it exists, update it.
    if ($this->getUser($username)) {
        $stmt = $this->db->prepare($sql = sprintf('UPDATE %s SET password=:password, first_name=:firstName, last_name=:lastName where username=:username', $this->config['user_table']));
    } else {
        $stmt = $this->db->prepare(sprintf('INSERT INTO %s (username, password, first_name, last_name) VALUES (:username, :password, :firstName, :lastName)', $this->config['user_table']));
    }

    return $stmt->execute(compact('username', 'password', 'firstName', 'lastName'));
}
}