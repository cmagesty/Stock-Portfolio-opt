<?php
	$username = $_POST['username'];
    $password = $_POST['password'];
    require_once( "../utility/connect.php" );
    
    create_user( $username, $password );
    
    
    function create_user( $username, $password ){
        $db = connect();
        try{
            session_start();            
            validate_create( $username );
            $sql_stmt = "INSERT INTO 490_users ( `username`, `password` ) VALUES( :username, :password )";
            $query = $db -> prepare( $sql_stmt );
            $query -> bindValue( ":password", $password );
            $query -> bindValue( ":username", $username );
            $query -> execute();
            $_SESSION['login_message'] = "Account created successfully. Please Log In.";
            header("Location: ../index.php");
        }
        catch( Exception $e ){
            $_SESSION['login_message'] = $e -> getMessage();
            header("Location: ../view/v_create_user.php" );
        }
    }
    
    function validate_create( $username ){
        $db = connect();
        $sql_stmt = "SELECT * FROM 490_users WHERE `username` = :username";
        $query = $db -> prepare( $sql_stmt );
        $query -> bindValue( ":username", $username );
        $query -> execute();
        $num_returned = $query -> rowCount();
        if( $num_returned > 0 ){
            throw new Exception( "Could not create user, username taken." );
        }
        else{
            return;
        }
    }
