<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 3/20/2016
 * Time: 10:52 AM
 */

require_once 'core/init.php';

?>
<form action="login.php" method="POST">
    <div>
        <h3 id="signin"><strong>Sign in</strong></h3>
    </div>

    <div>
        <label>Username</label><br>
        <input required id="username" type="text" name="username" autocomplete="off" placeholder="Enter username"/>
    </div>
    <div>
        <label>Password</label><br>
        <input required type="password" name="password" autocomplete="off" placeholder="Enter password"/>
    </div>
    <div>
        <input type="checkbox"  name="remember"/> Remember me
    </div>

    <div >
        <input type="submit" value="Sign in" name="signin"/>
    </div>
    <div>
        <a href="#" title="To recover your password, click here " >Forgot password?</a>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>
<div>
    <a href="register.php"><button class="btn btn-default col-sm-12" id="signupButton">Sign up</button></a>
</div>