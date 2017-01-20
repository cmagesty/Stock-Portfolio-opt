<?php
require_once( "Record.php" );
class Purchase_record extends Record {
    private $symbol;
    private $shares;
    private $purchase_price;
    private $purchase_amount;
    
    public function create( $symbol, $shares, $purchase_price ){
        $purchase_amount = ( $purchase_price * $shares );
        $purchase_price_formatted = $this -> format_usd( $purchase_price );
        $purchase_amount_formatted = $this -> format_usd( $purchase_amount );
        $this -> symbol = $symbol;
        $this -> shares = $shares;
        $this -> purchase_price = $purchase_price_formatted;
        $this -> purchase_amount = $purchase_amount_formatted;
        $this -> save_db();
    }
    
    protected function save_db(){
        $sql_stmt = "INSERT INTO 490_purchase_records ( `timestamp`, `symbol`, `shares`, `purchase_price`, `purchase_amount`, `port_id` ) VALUES ( :timestamp, :symbol, :shares, :purchase_price, :purchase_amount, :port_id )";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":timestamp", $this -> timestamp );
        $query -> bindValue( ":symbol", $this -> symbol );
        $query -> bindValue( ":shares", $this -> shares );
        $query -> bindValue( ":purchase_price", $this -> purchase_price );
        $query -> bindValue( ":purchase_amount", $this -> purchase_amount );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();        
    }
    
    public function get_all_records(){
        $sql_stmt = "SELECT `timestamp`, `symbol`, `shares`, `purchase_price`, `purchase_amount`, `port_id` FROM 490_purchase_records WHERE `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
        $results = $query->fetchAll(PDO::FETCH_NUM);
        return $results;
    }
}
