<?php
	require( "../model/Lot.php" );
    session_start();
    $symbol = strtoupper( $_POST['symbol'] );
    $shares = $_POST['shares'];
    $new_lot = new Lot();
    $new_lot -> create_new( $symbol, $shares );
    header( "Location: ../view/v_portfolio.php" );
    

