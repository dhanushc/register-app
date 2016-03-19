<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 11/08/15
 * Time: 19:26
 */

require_once 'core/init.php';
require 'SMS/sms.php';
require 'Files/accessFile.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | Page</title>
    <?php include 'headerScript.php'?>
</head>
<body>
<div>
    <?php
    include "header.php";
    ?>
</div>
<div class="backgroundImg container-fluid">
    <br>
    <div class="jumbotron col-lg-6 col-lg-offset-3">
<?php

$notification = new smsNotification();
//echo "To confirm your registration enter your registration code..." . '<br />';
$hiddenValue = Input::get('storeRandVal');
$randomValue = rand(1000, 9999);
//echo $randomValue;
$file = new accessFile();
$detailArray = $file->read('Files/RouterPhone');
$messageArray = $file->read_newLine('Files/messages');
$from = $detailArray[0];
$pNumber = $_SESSION['phoneNo'];
$to = '94'.substr($pNumber,1,9);
$pass = $detailArray[1];
$message = $messageArray[0];
$var = $notification->send($from,$to,$message ." ". $randomValue ,$pass); //for db
//echo $var;

$var1 = $_SESSION['username'];
$var2 = Hash::make($_SESSION['password']);
$var3 = $_SESSION['regNo'];
$var4 = $_SESSION['name1'];
$var5 = $_SESSION['name2'];
$var6 = $_SESSION['email'];
$var7 = $_SESSION['phoneNo'];
$var8 = $_SESSION['nic'];
$var9 = $_SESSION['dob'];
$var10 = $_SESSION['year'];


if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'rand_number' => array(
                'required' => true,
                'min' => 4,
                'max' => 4,
            )
        ));
        if($validation->passed()){
            $input = htmlspecialchars(trim(Input::get('rand_number')));
            if($input == $hiddenValue){
                $user = new User();
                try{
                    $user->create(array(
                        'username'  => $var1,
                        'password'  => $var2,
    //                    'salt' => $salt,
                        'regNumber' => $var3,
                        'fname'     => $var4,
                        'lname'     => $var5,
                        'email'     => $var6,
                        'phone'     => $var7,
                        'nic'       => $var8,
                        'dob'       => $var9,
    //                  'course'  => Input::get('course'),
                        'year'      => $var10,
                        'group'     => 1
                    ));
                    Session::flash('home', 'You are registered!');
                    Redirect::to('index.php');
                }catch (Exception $e){
//                    Redirect::to('index.php');
                    die($e->getMessage());
                }

            } elseif ($randomValue != $hiddenValue) {
//                echo "error";
                Session::flash('home', 'you enter wrong key code.');
                Redirect::to('index.php');
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '</ br>';
            }
        }
    }
}
//session_unset();
?>

        <form action="" method="post">
            <div class="field">
                <label>Enter number </label>
                <input class="form-control" type="number" name="rand_number" id="rand_number">
            </div>
            <input type="hidden" name="storeRandVal" value="<?php echo $randomValue; ?>">
            <input class="btn btn-default" type="submit" value="Register">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>

    </div>
</div>

<?php
include "footer.php";
?>

</body>
</html>