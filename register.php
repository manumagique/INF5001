<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 2:58 AM
 */

require_once 'core/init.php';
//var_dump(Token::check(Input::get('token')));

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
            $validate = new Validation();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'min' => 20,
                    'unique' => 'user'
                ),
                'pwd' => array(
                    'required' => true,
                    'min' => 6

                ),
                'pwd2' => array(
                    'require' => true,
                    'matches' => 'pwd'
                )
            ));
            if ($validation->passed()) {
               Session::flash('success', 'you registered successfully');
               $user = new User();
               $salt = Hash::salt(32);
               try
               {
                   $user->create( array(
                       'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                   ));

                   Session::flash('home', 'vous avez été ajouté comme utilisateur');
                   Redirect::to('index.php');

               }
               catch (Exception $e)
               {
                   die($e->getMessage());
               }
            } else {
                print_r($validation->errors());
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

    <div class="field">
        <label for=""password2">password again</label>
        <input type="text" name="password2" id="password2" autocomplete="off">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="register">
</form>
</body>
</html>