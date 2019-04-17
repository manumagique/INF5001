<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-04-01
 * Time: 11:54
 */
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Methods:GET,POST,PUT,DELETE');
//header('Access-Control-Allow-Headers:X-Requested-With');

include_once '../Functions/cors.php';

cors();

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();