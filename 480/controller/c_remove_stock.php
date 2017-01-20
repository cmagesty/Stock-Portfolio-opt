<?php
require_once( "../model/Lot.php" );
session_start();
$lot_id = $_POST['lot_id'];
$shares = $_POST['shares'];
echo $lot_id;
$lot = new Lot();
$lot -> instantiate( $lot_id );
$lot -> sell( $shares );
header( "Location: ../view/v_lots.php" );
