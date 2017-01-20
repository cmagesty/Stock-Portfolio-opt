<?php
require_once( "../utility/connect.php" );
require_once( "../model/Stock.php" );
require_once( "../model/Lot.php" );
require_once( "../model/Cash_record.php" );
class Portfolio{
    private $db;
    private $percent_foreign;
    private $percent_domestic;
    private $percent_cash;
    private $name;
    private $num_stocks;
    private $username;
    private $cash;
    private $port_id;
    private $stocks;
    
    function __construct(){
        $this -> db = connect();
    }
    
    function create( $name ){
        $this -> name = $name;
        $this -> username = $_SESSION['username'];
        $this -> cash = 0;
        $this -> save_new();
    }
    
    function instantiate( $port_id ){
        try{
            $this -> port_id = $port_id;
            $_SESSION['port_id'] = $this -> port_id;
            $this -> username = $_SESSION['username'];
            $this -> populate_portfolio();
            $this -> populate_stocks();
            $this -> calculate_percentages();
            $this -> validate_portfolio();
        }
        catch( Exception $e ){
            $_SESSION[ 'portfolio_error' ] = $e -> getMessage();
        }
    }
    
    function populate_portfolio(){
        $sql_port = "SELECT `name`, `cash` FROM 490_portfolios WHERE `port_id` = :port_id AND `username` = :username";
        $query = $this -> db -> prepare( $sql_port );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> bindValue( ":username", $this -> username );
        $query -> execute();
        $results = $query -> fetchAll();
        foreach( $results as $row => $results_list ){
            $this -> name = $results_list[0];
            $this -> cash = $results_list[1];
        }
        if( ! isset( $this -> cash ) ){
            $this -> cash = 0;
        }
    }
    
    function populate_stocks(){
        $sql_stocks = "SELECT `symbol` FROM 490_stocks WHERE `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stocks );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
        $this -> num_stocks = $query -> rowCount();
        $results = $query -> fetchAll();
        $this -> stocks = array();
        foreach( $results as $row ){
            $cur_symbol = $row[0];
            $this -> stocks[] = new Stock( $cur_symbol );
        }
    }
    
    function calculate_percentages(){
        $total_value = $this -> cash;
        $total_domestic = 0;
        $total_foreign = 0;
        foreach( $this -> stocks as $stock ){
            $stock_value = $stock -> get_domestic() * $stock ->get_shares_owned();
            $total_value += $stock_value;
            if( $stock -> get_is_foreign() ){
                $total_foreign += $stock_value;
            }
            else{
                $total_domestic += $stock_value;
            }
        }
        if( $total_value != 0 ){
            $this -> percent_foreign = $total_foreign / $total_value *100;
            $this -> percent_domestic = $total_domestic / $total_value * 100;
            $this -> percent_cash = $this -> cash / $total_value * 100;
        }
            $this -> percent_foreign = number_format( $this -> percent_foreign, 2 );
            $this -> percent_domestic = number_format( $this -> percent_domestic, 2);
            $this -> percent_cash = number_format( $this -> percent_cash, 2);
    }
    
    function add_funds( $funds ){
        $new_amount = $this -> cash + $funds;
        $new_amount_formatted = number_format( $new_amount, 2 );
        $this -> update_funds( $new_amount );
    }
    
    function remove_funds( $funds ){
        try{
            $this -> validate_remove_cash( $funds );
            $new_amount = $this -> cash - $funds; 
            $new_amount_formatted = number_format( $new_amount , 2 );
            $this -> update_funds( $new_amount );
        }
        catch( Exception $e ){
            throw $e;
        }
    }
    
    
    function update_funds( $new_amount ){
        $sql_stmt = "UPDATE 490_portfolios SET `cash` = :new_amount WHERE `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":new_amount", $new_amount );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
    }
    
    function save_new(){
        $sql_stmt = "INSERT INTO 490_portfolios ( `name`, `cash`, `username`) VALUES ( :name, :cash, :username )";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":name", $this -> name );
        $query -> bindValue( ":cash", $this -> cash );
        $query -> bindValue( ":username", $this -> username );
        $query -> execute();
    }
    
    function save_existing(){
        $sql_stmt = "UPDATE 490_portfolios SET `cash` = :cash WHERE `username` = :username AND `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":cash", $this -> cash );
        $query -> bindValue( ":username", $this -> username );
        $query -> bindValue( ":port_id", $this -> port_id );
    }
    
    function validate_remove_cash( $funds_to_remove ){
        if( $funds_to_remove > $this -> cash ){
            throw new Exception( "Could not remove funds, insufficent funds." );
        }
    }
    function validate_portfolio(){
        $full_message = "";
        $error = false;
        $domestic_message = "Foreign stocks are " . $this -> percent_foreign . "% of portfolio.<br>"
                . "Foreign stocks should comprise of 30% of total portfolio value.<br>";
        $foreign_message = "Domestic stocks are " . $this -> percent_domestic . "% of portfolio.<br>"
                . "Domestic stocks should comprise of 70% of total portfolio value.<br>";
        $cash_message = "Cash funds are " . $this -> percent_cash ."% of portfolio value.<br>"
                . "Cash funds should not comprise of more than 10% of portfolio value.<br>";
        
        if( $this -> percent_domestic < 67 OR $this -> percent_domestic > 73 ){
            $error = true;
            $full_message = $full_message . $domestic_message;
        }
        if( $this -> percent_foreign < 27 OR $this -> percent_foreign > 33 ){
            $error = true;
            $full_message = $full_message . $foreign_message;
        }

        if( $this -> percent_cash > 10 ){
            $error = true;
            $full_message = $full_message . $cash_message;
        }

            if( $error ){
                throw new Exception( $full_message );
            }
            
    }
    
    function get_lots(){
        $sql_stocks = "SELECT `lot_id` FROM 490_lots WHERE `port_id` = :port_id";
        $query = $this -> db -> prepare( $sql_stocks );
        $query -> bindValue( ":port_id", $this -> port_id );
        $query -> execute();
        $results = $query -> fetchAll();
        $lots = array();
        foreach( $results as $row ){
            $cur_lot_id = $row[0];
            $cur_lot = new Lot();
            $cur_lot -> instantiate( $cur_lot_id );
            $lots[] = $cur_lot;
        }
        return $lots;
    }
    function get_cash(){
        return $this -> cash;
    }
    
    function get_name() {
        return $this->name;
    }

    function get_stocks(){
        return $this -> stocks;
    }
    function get_id() {
        return $this->port_id;
    }
}
        
