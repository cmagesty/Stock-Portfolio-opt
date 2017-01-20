<?php
require_once( "../utility/connect.php" );
require_once( "../model/Stock_fetcher.php" );
require_once( "../model/Portfolio.php" );
require_once( "../model/Purchase_record.php" );
require_once( "../model/Cash_record.php" );

    Class Stock{
        private $db;
        private $cur_us_price;
        private $cur_foreign_price;
        private $is_foreign;
        private $symbol;
        private $name;
        private $exchange;
        private $shares_owned;
        private $value_owned;
        private $port_id;
        private $currency;
        private $previously_traded;
        private $stock_owned;
                
        function __construct ( $symbol ){
            $this -> port_id = $_SESSION['port_id'];
            $this -> symbol = $symbol;
            $this -> db = connect();
            $this -> determine_if_owned();
            $this -> determine_if_traded();
            $this -> fetch_api();
            if( $this -> stock_owned ){
                $this -> fetch_db();
            }
        }
        
        function fetch_api(){
            $stock_fetcher = new Stock_fetcher( $this -> symbol, $this -> previously_traded );
            $this -> name = $stock_fetcher -> get_name();
            $this -> exchange = $stock_fetcher -> get_exchange();
            $this -> currency = $stock_fetcher -> get_currency();
            $this -> is_foreign = $stock_fetcher -> get_is_foreign();
            $this -> cur_us_price = $stock_fetcher -> get_us_price();
            $this -> cur_foreign_price = $stock_fetcher -> get_foreign_price();
        }
        
        function fetch_db(){
            try{
                $sql_stmt = "SELECT shares_owned, value_owned FROM 490_stocks WHERE symbol = :symbol AND port_id = :port_id";
                $query = $this -> db -> prepare( $sql_stmt );
                $query -> bindValue( ":symbol", $this -> symbol );
                $query -> bindValue( ":port_id", $this -> port_id );
                $query -> execute();
                $result = $query -> fetchAll();
                foreach( $result as $row => $results_list){
                    $this -> shares_owned = $results_list[0];
                    $this -> value_owned = $results_list[1];
                }
            } catch (Exception $e) {
                echo $e -> getMessage();
            }
        }
        
        function add_stocks( $shares_to_buy ){
            try{
                $this -> validate_add( $shares_to_buy );
                $amount_raw = $this -> cur_us_price * $shares_to_buy;
                $amount_formatted = number_format( $amount_raw, 2 );
                $new_shares = $this -> shares_owned + $shares_to_buy;
                $new_value = $this -> value_owned - $amount_formatted;
                $this -> shares_owned = $new_shares;
                $this -> value_owned = $new_value;
                $this -> save_db();
                $this -> add_to_traded();
                $port = new Portfolio();
                $port -> instantiate( $this -> port_id );
                $port -> remove_funds( $amount_raw );
                $record = new Purchase_record();
                $record -> create( $this -> symbol, $shares_to_buy, $this -> cur_us_price );
            }
            catch( Exception $e ){
                throw $e;
            }
        }    
        
        function remove_stocks( $shares_to_sell ){
            try{
                //validate_remove();
                $amount_raw = $this -> cur_us_price * $shares_to_sell;
                $amount_formatted = number_format( $amount_raw, 2 );
                $new_shares = $this -> shares_owned - $shares_to_sell;
                $new_value = $this -> value_owned + $amount_formatted;
                $this -> shares_owned = $new_shares;
                $this -> value_owned = $new_value;
                $this -> save_db();
                $port = new Portfolio();
                $port -> instantiate( $this -> port_id );
                $port -> add_funds( $amount_raw );
            }
            catch( Exception $e ){
                throw $e;
            }
        }
        
        function determine_if_traded(){
            $sql_stmt = "SELECT `symbol` FROM 490_traded WHERE `symbol` = :symbol AND `port_id` = :port_id";
            $query = $this -> db -> prepare( $sql_stmt );
            $query -> bindValue( ":symbol", $this -> symbol );
            $query -> bindValue( ":port_id", $this -> port_id );
            $query -> execute();
            $num_returned = $query -> rowCount();
            if( $num_returned > 0 ){
                $this -> previously_traded = true;
            }
            else{
                $num_returned = false;
            }
        }
        
        function determine_if_owned(){
            $sql_stmt = "SELECT `symbol` FROM 490_stocks WHERE symbol = :symbol AND port_id = :port_id";
            $query = $this -> db -> prepare( $sql_stmt );
            $query -> bindValue( ":symbol", $this -> symbol );
            $query -> bindValue( ":port_id", $this -> port_id );
            $query -> execute();
            $rows = $query -> rowCount();
            if ( $rows == 0 ){
                $this -> stock_owned = false;
            }
            else {
                $this -> stock_owned = true;
            }
        }
        
        function validate_add( $num_shares ){
            $cur_port = new Portfolio();
            $cur_port ->instantiate( $this -> port_id );
            $cur_funds = $cur_port -> get_cash();
            $total_cost = $this -> cur_us_price * $num_shares;
            if ( $total_cost > $cur_funds ){
                throw new Exception( "Could not add stock, not enough funds." );
            }
        }
        
        function validate_remove( $num_shares ){

        }
        
        function add_to_traded(){
            try{
                $sql_stmt = "INSERT INTO 490_traded (`symbol`, `port_id`) VALUES( :symbol, :port_id )";
                $query = $this -> db -> prepare ( $sql_stmt );
                $query -> bindValue( ":symbol", $this -> symbol );
                $query -> bindValue( ":port_id", $this -> port_id );
                $query -> execute();
                }
                catch( Exception $e ){
                    throw $e;
                }
        }
        
        function save_db(){
            try{
                if ( $this -> stock_owned ){
                    if( $this -> shares_owned == 0 ){
                        $sql_stmt = "DELETE FROM 490_stocks WHERE `port_id` = :port_id AND `symbol` = :symbol";
                        $query = $this -> db -> prepare( $sql_stmt );
                        $query -> bindValue( ":port_id", $this -> port_id );
                        $query -> bindValue( ":symbol", $this -> symbol );
                        $query -> execute();
                    }
                    else{
                        $sql_stmt = "UPDATE 490_stocks SET `shares_owned` = :shares_owned, `value_owned` = :value_owned WHERE `symbol` = :symbol AND `port_id` = :port_id";
                        $query = $this -> db -> prepare( $sql_stmt );
                        $query -> bindValue( ":shares_owned", $this -> shares_owned );
                        $query -> bindValue( ":value_owned", $this -> value_owned );
                        $query -> bindValue( ":symbol", $this -> symbol );
                        $query -> bindValue( ":port_id", $this -> port_id );
                        $query -> execute();
                    }
                }
                else{
                    $sql_stmt = "INSERT INTO 490_stocks ( `symbol`, `shares_owned`, `value_owned`, `port_id` ) VALUES ( :symbol, :shares_owned, :value_owned, :port_id )";
                    $query = $this -> db -> prepare( $sql_stmt );
                    $query -> bindValue( ":symbol", $this -> symbol );
                    $query -> bindValue( ":shares_owned", $this -> shares_owned );
                    $query -> bindValue( ":value_owned", $this -> value_owned );
                    $query -> bindValue( ":port_id", $this -> port_id );
                    $query -> execute();
                }
            }
                catch( Exception $e ){
                    throw $e;
                }
        }
        
        function get_foreign_f(){
            if( $this -> is_foreign ){
                $result = $this -> cur_foreign_price . " " . $this -> currency;
            }
            else{
                $result = $this -> cur_foreign_price;
            }
            return $result;
        }
        
        function get_domestic_f(){
            $result = $this -> cur_us_price . " " . "USD";
            return $result;
        }
        
        function get_symbol(){
            return $this -> symbol;
        }
        
        function get_name(){
            return $this -> name;
        }
        
        function get_domestic(){
            return $this -> cur_us_price;
        }
        
        function get_is_foreign(){
            return $this -> is_foreign;
        }
        
        function get_exchange(){
            return $this -> exchange;
        }
        
        function get_shares_owned(){
            return $this -> shares_owned;
        }
        
        function get_value_owned(){
            return $this -> value_owned;
        }
        
        function get_port_id(){
            $this -> port_id = $_SESSION[ 'port_id' ];
        }
    }
     