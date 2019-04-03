<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 1:17 PM
 */
require_once 'core/init.php';
if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true),
        ));

        if ($validation->passed())
        {
            $user = new User();
            $login = $user->login(Input::get('username'), Input::get('password'));

            if ($login)
            {
                Redirect::to('index.php');
            }
            else
            {
                echo '<p> désolé, la connection a échoué<p>';
            }
        }
        else
        {
            foreach ($validation->errors() as $error)
            {
                echo $error , '<br>';
            }
        }
    }
}
?>
<html>
<head>

</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for=""username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
        <label for=""password">password</label>
        <input type="text" name="password" id="password" autocomplete="off">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="log in">
</form>
</body>
</html>
