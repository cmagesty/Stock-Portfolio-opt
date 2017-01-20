<?php
	require( "../model/User.php" );
    require_once( "../utility/connect.php" );
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    log_in( $username, $password );
    
    
    function log_in( $username, $password ){
    try{
        session_start();
        validate_credentials( $username, $password );
        $_SESSION['username'] = $username;
        header( "Location: ../view/v_landing.php" );
    }
    catch( Exception $e ){
        $_SESSION['login_message'] = $e -> getMessage();
        header("location: ../index.php" );
    }
}

    function validate_credentials($username, $password ){
        $sql_stmt = "SELECT * FROM 490_users WHERE `username` = :username AND `password` = :password";
        $db = connect();
        $query = $db -> prepare( $sql_stmt );
        $query -> bindValue( ":username", $username );
        $query -> bindValue( ":password", $password );
        $query -> execute();
        $num_returned = $query -> rowCount();
        if( $num_returned == 0 ){
            throw new Exception( "Incorrect username or password." );
        }
        else{
            return;
        }
    }

