<?php
// include our OAuth2 Server object
require_once __DIR__ . '/server.php';
function newOauthUser(){
    $storage->setUser("john","123456", "pierre", "jean");
}
