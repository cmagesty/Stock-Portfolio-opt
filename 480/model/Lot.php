<?php
require_once( "Stock.php" );
require_once( "../model/Sale_record.php" );
class Lot {
    private $db;
    private $symbol;
    private $shares;
    private $name;
    private $us_cur;
    private $us_purchase;
    private $foreign_cur;
    private $foreign_purchase;
    private $purchase_date;
    private $port_id;
    private $lot_id;
    private $stock;
    
    function __construct(){
        $this -> db = connect();
        $this -> port_id = $_SESSION['port_id'];
    }
    
    function create_new( $symbol, $shares ){
        try{
            $this -> stock = new Stock( $symbol );
            $this -> name = $this -> stock -> get_name();
            $this -> symbol = $symbol;
            $this -> shares = $shares;
            $this -> stock -> add_stocks( $shares );
            $this -> us_purchase = $this -> stock -> get_domestic_f();
            $this -> foreign_purchase = $this -> stock -> get_foreign_f();
            echo $this -> us_purchase;
            echo $this -> foreign_purchase;
            $this -> purchase_date = date("m/d/Y h:i:s a");
            $this -> save_new();
            //new Record( Record::BUY, $this -> us_cur, $this -> symbol, $shares );
        }
        catch( Exception $e ){
            $_SESSION[ 'add_stock_error' ] = $e -> getMessage();
        }
    }
    
    function instantiate( $lot_id ){
    try{//fix db
        $this -> lot_id = $lot_id;
        $sql_stmt = "SELECT symbol, shares, name, us_purchase, foreign_purchase, purchase_date FROM 490_lots WHERE `lot_id` = :lot_id AND `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":lot_id", $lot_id );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
        $results = $query -> fetchAll();
        foreach( $results as $row => $results_list ){
            $this -> symbol = $results_list[0];
            $this -> shares = $results_list[1];
            $this -> name = $results_list[2];
            $this -> us_purchase = $results_list[3];
            $this -> foreign_purchase = $results_list[4];
            $this -> purchase_date = $results_list[5];
        }
            $this -> stock = new Stock( $this -> symbol );
            $this -> us_cur = $this -> stock -> get_domestic();
            $this -> foreign_cur = $this -> stock -> get_is_foreign();
    }
    catch( Exception $e ){
        echo $e -> getMessage();
    }
}

    function save_existing(){
        if( $this -> shares == 0 ){
            $this -> delete_lot();
        }
        else{
            $sql_stmt = "UPDATE 490_lots SET `shares` = :shares WHERE `port_id` = :port_id AND `lot_id` = :lot_id";
            $query = $this -> db -> prepare( $sql_stmt );
            $query -> bindValue( ":shares", $this -> shares );
            $query -> bindValue( ":port_id", $this -> port_id );
            $query -> bindValue( ":lot_id", $this -> lot_id );
            $query -> execute(); 
        }
    }
    
    function sell( $shares_to_sell ){
        try{
            echo $shares_to_sell;
            echo $this -> shares;
            if( $shares_to_sell > $this -> shares ){
                throw new Exception( "Could not sell, requested amount to sell exceeds number of shares in lot." );
            }
            $this -> stock -> remove_stocks( $shares_to_sell );
            $this -> shares -= $shares_to_sell;
            $this -> save_existing();
            $record = new Sale_record();
            $record -> create( $this -> purchase_date, $this -> symbol, $shares_to_sell, $this -> us_purchase, $this -> us_cur );
        } catch (Exception $e) {
                $_SESSION['sell_error'] = $e -> getMessage();
        }
    }
    
    function delete_lot(){
        $sql_stmt = "DELETE FROM 490_lots WHERE `port_id` = :port_id AND `lot_id` = :lot_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> bindValue( ":lot_id", $this -> lot_id );
        $query -> execute();
    }
    
    function save_new(){
        try{
            $sql_stmt = "INSERT INTO 490_lots( `symbol`, `shares`, `name`, `us_purchase`, `foreign_purchase`, `purchase_date`, `port_id` ) VALUES"
                    . "( :symbol, :shares, :name, :us_purchase, :foreign_purchase, :purchase_date, :port_id )";
            $query = $this -> db -> prepare( $sql_stmt );
            $query -> bindValue( ":symbol", $this -> symbol );
            $query -> bindValue( ":shares", $this -> shares );
            $query -> bindValue( ":name", $this -> name );
            $query -> bindValue( ":us_purchase", $this -> us_purchase );
            $query -> bindValue( ":foreign_purchase", $this -> foreign_purchase );
            $query -> bindValue( ":purchase_date", $this -> purchase_date );
            $query -> bindValue( ":port_id", $this -> port_id );
            $query -> execute();
        }
        catch( Exception $e ){
            echo $e -> getMessage();
        }
    }
    function get_lot_id() {
        return $this->lot_id;
    }

    function get_domestic_cur(){
        return $this -> stock -> get_domestic_f();
    }
    
    function get_foreign_cur(){
        return $this -> stock -> get_foreign_f();
    }
    
    function get_symbol() {
        return $this->symbol;
    }

    function get_shares() {
        return $this->shares;
    }

    function get_name() {
        return $this->name;
    }

    function get_purchase_date() {
        return $this->purchase_date;
    }
    
    function get_domestic_purchase() {
        return $this->us_purchase;
    }

    function get_foreign_purchase() {
        return $this->foreign_purchase;
    }



    
    
}
