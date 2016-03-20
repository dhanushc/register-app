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
                'email' => array(
                    'required' => true,
                    'unique' => 'participant'
                ),
                'tshirtSize' => array(
                    'required' => true
                )
            )
        );
        if($validation->passed()) {
            $user = new User();
            try{
                $user->create(array(
                     'firstName' => Input::get('name1'),
                     'lastName' => Input::get('name2'),
                    'email'=> Input::get('email'),
                     'contact' => Input::get('contact'),
                       'tshirtSize' => Input::get('tshirtSize'),
                'university'=> Input::get('university'),
                  'studentRegNo'     => Input::get('studentRegNo'),
                    'informedMethod'   => Input::get('informedMethod')
                    //other data
                ));

                echo '<script type="text/javascript">alert("Registered successfully")</script>';
            }catch (Exception $e){
                die($e->getMessage());
            }
        } else {
            $str = "";
            foreach ($validation->errors() as $error) {
                $str .= $error;
                $str .= '\n';
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
            <input type = "hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" value="Register">
        </form>

</body>
</html>