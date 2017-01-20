<?php
require_once( "../utility/connect.php" );
class Record {
    protected $db;
    protected $timestamp;
    protected $port_id;
    
    function __construct(){
        $this -> db = connect();
        $this -> timestamp = date("m/d/Y h:i:s a");
        $this -> port_id = $_SESSION[ 'port_id' ];
    }
    
    function format_usd( $amount ){
        $formatted = "\$" . $amount;
        return $formatted;
    }
}
