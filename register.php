<?php
require_once 'core/init.php';

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title>Register | page</title>
    <?php include 'headerScript.php'?>
</head>
<body>

<?php
include 'header.php';
?>
<div class="backgroundImg container-fluid" >
    <br>
    <div id="regForm" class="jumbotron col-lg-5 col-lg-offset-3">
<?php
//var_dump — Dumps information about a variable
//var_dump(Token::check(Input::get('token')));

if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}
//checking if the user already logged in
$user = new User();
if($user->isLoggedIn()){
    Redirect::to('dashboard_student.php');
}


if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                ),
                'phoneNo' => array(
                    'required' => true,
                    'min' => 10
                ),
                'nic' => array(
                    'required' => true,
                    'min' => 10
                )
            )
        );
        if($validation->passed()) {
			$_SESSION['username'] = Input::get('username');
            $_SESSION['password'] = Input::get('password');
            $_SESSION['regNo']    = Input::get('regNumber');
            $_SESSION['name1']    = Input::get('name1');
            $_SESSION['name2']    = Input::get('name2');
            $_SESSION['email']    = Input::get('email');
            $_SESSION['phoneNo']    = Input::get('phoneNo');
            $_SESSION['nic']      = Input::get('nic');
            $_SESSION['dob']      = Input::get('dob');
            $_SESSION['year']     = Input::get('year');
            Redirect::to('registerConfirm.php');
        } else {
            $str = "";
            foreach ($validation->errors() as $error) {
//                echo $error, '</ br>';
                $str .= $error;
                $str .= '\n';
//                echo '<script type="text/javascript">alert("' . $error . '")</script>';
//                echo "<div class='alert alert-danger'> $error</div>";
            }
            echo '<script type="text/javascript">alert("' . $str . '")</script>';
        }
    }
}


?>



        <img class="col-lg-offset-4" src="images/ucsc.png" height="100px">
        <form action="" method="post">
            <div>
                <h3 id="signup"><strong>Sign up</strong></h3>
            </div>

            <div class="gap">
                <label>Username</label><br>
                <input class="form-control" id="username" type="text" name="username"  placeholder="Enter username" value="<?php echo Input::get('username'); ?>" autocomplete="off" >
            </div>
            <div class="gap">
                <label>Password</label><br>
                <input class="form-control" id="password" type="password" name="password" placeholder="Enter password">
            </div>

            <div class="gap">
                <label>Re-Password</label><br>
                <input class="form-control" id="password_again" type="password" name="password_again" placeholder="Enter your password again">
            </div>

            <div class="gap">
                <label>First Name</label><br>
                <input class="form-control" id="name1" type="text" name="name1" placeholder="Your first name" value="<?php echo escape(Input::get('name1')); ?>">
            </div>
            <div class="gap">
                <label>Last Name</label><br>
                <input class="form-control" id="name2" type="text" name="name2" placeholder="Your last name" value="<?php echo escape(Input::get('name2')); ?>">
            </div>
            <div class="gap">
                <label>UCSC Registration No</label><br>
                <input class="form-control" id="regNumber" type="text" name="regNumber" placeholder="UCSC registration number" value="<?php echo escape(Input::get('regNumber'));?>">
            </div>
            <div class="gap">
                <label>E-Mail</label><br>
                <input class="form-control" id="email" type="email" name="email" placeholder="email address" value="<?php echo escape(Input::get('email')); ?>">
            </div>
            <div class="gap">
                <label>Mobile</label><br>
                <input class="form-control" id="phoneNo" type="text" name="phoneNo" placeholder="Mobile number" value="<?php echo escape(Input::get('phoneNo')); ?>">
            </div>
            <div class="gap">
                <label>N.I.C No</label><br>
                <input class="form-control" id="nic" type="text" name="nic" placeholder="NIC number" value="<?php echo escape(Input::get('nic')); ?>">
            </div>
            <div class="gap">
                <label>Date of Birth</label><br>
                <input class="form-control" id="dob" type="date" name="dob" placeholder="Date of birth" value="<?php echo escape(Input::get('dob')); ?>">
            </div>

            <div class="gap">
                <label>Academic Year</label><br>
                <select class="form-control" id="year" name="year">
                    <option value="<?php echo escape("1"); ?>">First Year</option>
                    <option value="<?php echo escape("2"); ?>">Second Year</option>
                    <option value="<?php echo escape("3"); ?>">Third Year</option>
                    <option value="<?php echo escape("4"); ?>">Fourth Year</option>
                </select>
            </div>

			<div class="gap">
                <input type="checkbox" name="accept"> I agree to the <a href="">Terms and Conditions</a> and <a href="">Privacy Policy</a>
            </div>
            <input type = "hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input class="btn btn-default" id="next" type="submit" value="Next">
        </form>
    </div>
</div>

<?php
include "footer.php";
?>

</body>
</html>