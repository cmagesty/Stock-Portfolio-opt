<?php
function connect(){
  $dsn = "mysql:host=sql1.njit.edu;dbname= cam49";
  $db_uname = " ";
  $db_password = " ";

  try{  //database connection block
    $db = new PDO( $dsn, $db_uname, $db_password );
    $db -> setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  } catch ( PDOException $e ) {
    echo "Database connection issue : ".$e -> getMessage();
  }
  return $db;
  }

function remove_funds($amount, $portfolio){
  $db = connect();
  $sql_stmt =
    "UPDATE 490_Portfolios
SET funds = funds - $amount
WHERE name = '$portfolio' ;";
  try{ 
    $db -> exec( $sql_stmt );
  } catch ( PDOException $e ) { echo $e -> getMessage(); }
}
function get_funds($portfolio){
  $db = connect();
  $sql_stmt =
    "SELECT funds
FROM 490_Portfolios
WHERE name = '$portfolio' ;";
  try{
    $result = $db -> query( $sql_stmt );
  } catch ( PDOException $e ) { echo $e->getMessage(); } 
   $funds;
foreach( $result as $row)
  $funds = $row[0];
  return $funds; 
}
?>