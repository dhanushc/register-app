<?php
require_once 'core/init.php';

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title>Register | page</title>
</head>
<body>
<?php
//var_dump — Dumps information about a variable
//var_dump(Token::check(Input::get('token')));

if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}
//checking if the user already logged in
$user = new User();
if($user->isLoggedIn()){
    Redirect::to('dashboard.php');
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
                'contact' => array(
                    'required' => true,
                    'min' => 10
                ),
                'tshirtSize' => array(
                    'required' => true
                ),
            )
        );
        if($validation->passed()) {
			$_SESSION['username'] = Input::get('username');
            $_SESSION['password'] = Input::get('password');
            $_SESSION['name1']    = Input::get('name1');
            $_SESSION['name2']    = Input::get('name2');
            $_SESSION['email']    = Input::get('email');
            $_SESSION['contact']    = Input::get('contact');
            $_SESSION['tshirtSize']      = Input::get('tshirtSize');
            $_SESSION['university']      = Input::get('university');
            $_SESSION['studentRegNo']     = Input::get('studentRegNo');
            $_SESSION['informedMethod']     = Input::get('informedMethod');
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


        <form action="" method="post">
            <div>
                <h3 id="signup"><strong>Sign up</strong></h3>
            </div>

            <div>
                <label>Username</label><br>
                <input type="text" name="username"  placeholder="Enter username" value="<?php echo Input::get('username'); ?>" autocomplete="off" >
            </div>
            <div>
                <label>Password</label><br>
                <input type="password" name="password" placeholder="Enter password">
            </div>

            <div>
                <label>Re-Password</label><br>
                <input type="password" name="password_again" placeholder="Enter your password again">
            </div>

            <div>
                <label>First Name</label><br>
                <input type="text" name="name1" placeholder="Your first name" value="<?php echo escape(Input::get('name1')); ?>">
            </div>
            <div>
                <label>Last Name</label><br>
                <input type="text" name="name2" placeholder="Your last name" value="<?php echo escape(Input::get('name2')); ?>">
            </div>
            <div>
                <label>E-Mail</label><br>
                <input type="email" name="email" placeholder="Email address" value="<?php echo escape(Input::get('email')); ?>">
            </div>
            <div>
                <label>Contact</label><br>
                <input type="text" name="contact" placeholder="Contact Number" value="<?php echo escape(Input::get('contact')); ?>">
            </div>
            <div>
                <label>T-shirt Size</label><br>
                <select name="tshirtSize">
                    <option>Select</option>
                    <option value="<?php echo escape("XXL"); ?>">XXL</option>
                    <option value="<?php echo escape("XL"); ?>">XL</option>
                    <option value="<?php echo escape("L"); ?>">L</option>
                    <option value="<?php echo escape("M"); ?>">M</option>
                    <option value="<?php echo escape("S"); ?>">S</option>
                    <option value="<?php echo escape("XS"); ?>">XS</option>
                </select
            </div>
            <div>
                <label>University</label><br>
                <input type="text" name="university" placeholder="University" value="<?php echo escape(Input::get('university')); ?>">
            </div>
            <div>
                <label>Student Reg. Number</label><br>
                <input type="text" name="studentRegNo" placeholder="Student Reg. Number" value="<?php echo escape(Input::get('studentRegNo')); ?>">
            </div>
            <div>
                <label>Informed Method</label><br>
                <input type="text" name="informedMethod" placeholder="Informed Method" value="<?php echo escape(Input::get('informedMethod')); ?>">
            </div>

			<div>
                <input type="checkbox" name="accept"> I agree to the <a href="">Terms and Conditions</a> and <a href="">Privacy Policy</a>
            </div>
            <input type = "hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" value="Next">
        </form>

</body>
</html>