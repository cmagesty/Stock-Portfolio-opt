<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="myStyle.css">
<div class="user_form">
    <h1>Create a new Account</h1>
    <div class="error">
    <?php
//Author Tyler Hilsabeck
        session_start(); 
            if( isset( $_SESSION['login_message'] ) ){
                echo $_SESSION['login_message'];
                }
             session_destroy();
                ?>
    </div>
    <form action="../controller/c_create_user.php" method="POST">
        <p>Desired Username</p>
        <input type="text" name="username" placeholder="eg: WarrenBuffet1234" required/>
        <br>
        <p>Password</p>
        <input type="password"  name="password" placeholder="Password" required/>
        <br><br>
        <input type="submit" value="Submit"/>
    </form>
    <br>
    <form action="../index.php">
        <input type="submit" value="Return home"/>
    </form>
</div>
</html>