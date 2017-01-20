
<!DOCTYPE html>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="view/myStyle.css">
<body>
<div class="user_form" id="main_form">
    <h1>Left Group Portfolio Manager</h1>
    <br>
    <br>
    <p>Please sign in.<br> New user? <a href="view/v_create_user.php">Create a new account.</a></p>
    <div class="error">
<?php
    session_start(); 
        if( isset( $_SESSION['login_message'] ) ){
            echo $_SESSION['login_message'];
            }
         session_destroy();
            ?>
    </div>
    <form id="Form" action="controller/c_login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required/>
        <input type="password"  name="password" placeholder="Password" required/>
        <input type="submit" value="Log in"/>
    </form>
    <br>
</div>
</body>
</html>
