<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-12
 * Time: 2:01 PM
 */
require_once 'core/init.php';
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
Hello world
<?php

    if (Session::exists('home'))
{
    echo '<p>' . Session::flash('home') . '</p>';
}

    $user = new oauth_users();
    if ($user->isLoggedIn())
    {
        echo
        '<p>Hello <a href="#">' . escape($user->data()->username) . '</a>!</p>
        <ul>
            <li><a href="logout.php"></a>log out</li>
        </ul>';

    }
    else
    {
        echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
    }
?>

</body>
</html>

