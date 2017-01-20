<?php
require_once( "../utility/connect.php" );
require( "Portfolio.php" );
class User {
    private $db;
    private $username;
    private $all_portfolios;
    
    function __construct( $username ){
        $this -> db = connect();
        $this -> username = $username;
        $_SESSION['username'] = $username;
        $this -> populate_portfolios();
    }
    
    function populate_portfolios(){
        $sql_stmt = "SELECT `port_id` FROM 490_portfolios WHERE `username` = :username";
        $query = $this -> db -> prepare( $sql_stmt );
        $query -> bindValue( ":username", $this -> username );
        $query -> execute();
        $results = $query -> fetchAll();
        $this -> all_portfolios = array();
        foreach( $results as $row ){
            $port_id = $row[0];
            $cur_port = new Portfolio();
            $cur_port -> instantiate( $port_id );
            $this -> all_portfolios[] = $cur_port;
        }
    }
    
    function get_portfolios() {
        return $this->all_portfolios;
    }


    
}
