<?php
require( "../model/Portfolio.php" );
session_start();
$port_id = $_SESSION['port_id'];
$amount = $_POST['amount'];
try{
    $port = new Portfolio();
    $port -> instantiate( $port_id );
    $port -> remove_funds( $amount );
    $record = new Cash_record( Cash_record::REMOVE );
    $record -> create( $amount );    
    } catch (Exception $e) {
        $_SESSION['funds_error'] = $e -> getMessage();
    }   
//header( "Location: ../view/v_portfolio.php" ); 