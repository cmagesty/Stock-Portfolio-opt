<?php
require_once( "Record.php" );
class Cash_record extends Record {
    const ADD = 0;
    const REMOVE = 1;
    const ADD_MESSAGE = "Funds added";
    const REMOVE_MESSAGE = "Funds removed";
    private $message;
    private $amount;
    
    function __construct( $type ){
        parent::__construct();
        if( $type == Cash_record::ADD ){
            $this -> message = Cash_record::ADD_MESSAGE;
        }
        else if( $type == Cash_record::REMOVE ){
            $this -> message = Cash_record::REMOVE_MESSAGE;
        }
    }
    
    public function create( $amount ){
        $amount_formatted = $this -> format_usd( $amount );
        $this -> amount = $amount_formatted;
        $this -> save_db();
    }
    
    protected function save_db(){
        $sql_stmt = "INSERT INTO 490_cash_records ( `timestamp`, `message`, `amount`, `port_id` ) VALUES ( :timestamp, :message, :amount, :port_id )";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":timestamp", $this -> timestamp );
        $query -> bindValue( ":message", $this -> message );
        $query -> bindValue( ":amount", $this -> amount );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
    }
    
    public function get_all_records(){
        $sql_stmt = "SELECT `timestamp`, `message`, `amount` FROM 490_cash_records WHERE `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
        $results = $query->fetchAll(PDO::FETCH_NUM);
        return $results;
    }
    
    
    
    
}
