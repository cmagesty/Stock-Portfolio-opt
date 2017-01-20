<?php
require_once( "Record.php" );
class Sale_record extends Record{
    private $purchase_date;
    private $symbol;
    private $shares;
    private $purchase_price;
    private $sell_price;
    private $sale_amount;

    public function create( $purchase_date, $symbol, $shares, $purchase_price, $sell_price ){
        $sale_amount = $sell_price * $shares;
        $sale_amount_formatted = $this -> format_usd( $sale_amount );
        $purchase_price_formatted = $this -> format_usd( $purchase_price );
        $sell_price_formatted = $this -> format_usd( $sell_price );
        $this -> purchase_date = $purchase_date;
        $this -> symbol = $symbol;
        $this -> shares = $shares;
        $this -> purchase_price = $purchase_price_formatted;
        $this -> sell_price = $sell_price_formatted;
        $this -> sale_amount = $sale_amount_formatted;
        $this -> save_db();
    }
    
    protected function save_db(){
        $sql_stmt = "INSERT INTO 490_sale_records ( `timestamp`, `purchase_date`, `symbol`, `shares`, `purchase_price`, `sell_price`, `sale_amount`, `port_id` ) VALUES ( :timestamp, :purchase_date, :symbol, :shares, :purchase_price, :sell_price, :sale_amount, :port_id )";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":timestamp", $this -> timestamp );
        $query -> bindValue( ":purchase_date", $this -> purchase_date );
        $query -> bindValue( ":symbol", $this -> symbol );
        $query -> bindValue( ":shares", $this -> shares );
        $query -> bindValue( ":purchase_price", $this -> purchase_price );
        $query -> bindValue( ":sell_price", $this -> sell_price );
        $query -> bindValue( ":sale_amount", $this -> sale_amount );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
    }
    
    public function get_all_records(){
        $sql_stmt = "SELECT `timestamp`, `purchase_date`, `symbol`, `shares`, `purchase_price`, `sell_price`, `sale_amount` FROM 490_sale_records WHERE `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
        $results = $query->fetchAll(PDO::FETCH_NUM);
        return $results;
    }
   
}
