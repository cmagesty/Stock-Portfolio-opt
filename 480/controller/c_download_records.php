<?php
require_once( "../model/Sale_record.php" );
require_once( "../model/Purchase_record.php" );
require_once( "../model/Cash_record.php" );
session_start();
push_download();


function push_download(){
    $s_record = new Sale_record();
    $p_record = new Purchase_record();
    $c_record = new Cash_record( null );
    
    $s_records = $s_record -> get_all_records();
    $p_records = $p_record -> get_all_records();
    $c_records = $c_record -> get_all_records();
    
    $s_header = array( "Date", "Purchase Date", "Symbol", "Shares", "Purchase Price", "Sell Price", "Total Sale" );
    $p_header = array( "Date", "Symbol", "Shares", "Share Price", "Total Purchase" );
    $c_header = array( "Date", "Transaction", "Amount" );
    
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=records.csv");
    
    $file = fopen("php://output", "w" );
    
    fputcsv( $file, array( "Cash Transactions" ) );
    fputcsv( $file, $c_header );
    foreach( $c_records as $c_record ){
        fputcsv( $file, $c_record );
    }
    
    fputcsv( $file, array( "Stock Purchases") );
    fputcsv( $file, $p_header );
    foreach( $p_records as $p_record ){
        fputcsv( $file, $p_record );
    }
    
    fputcsv( $file, array( "Stock Sales") );
    fputcsv( $file, $s_header );
    foreach( $s_records as $s_record ){
        fputcsv( $file, $s_record );
    }
    
    fclose( $file );
    
}

