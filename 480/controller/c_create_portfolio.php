<!DOCTYPE html>
<?php
require( "../model/Portfolio.php" );
session_start();
$port_name = $_POST['port_name'];
$new_port = new Portfolio();
$new_port -> create( $port_name );
header( "location: ../view/v_landing.php" );


