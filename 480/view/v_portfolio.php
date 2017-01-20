<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="../view/myStyle.css">
<?php
//Author: Tyler Hilsabeck
    session_start();
    require( "../model/Portfolio.php" );
    //handles redirects from pages other than the landing page.
    if( isset( $_GET['id'] ) ){
        $port_id = $_GET['id'];
        $_SESSION['port_id'] = $port_id;
    }
    else{
        $port_id = $_SESSION['port_id'];
    }
    $port = new Portfolio();
    $port -> instantiate( $port_id );
    $port_name = $port -> get_name();
    $port_funds = $port -> get_cash();
    $port_stocks = $port -> get_stocks();
    ?>

<div class="user_form">
    <h1><?php echo $port_name?></h1>
    <h2>Cash in portfolio $<?php echo $port_funds?></h2>
    <div class="error">
            <?php if( isset( $_SESSION['add_stock_error'] ) ){
               ?>
            <p><?php echo $_SESSION['add_stock_error']; ?></p>
            <?php
                unset( $_SESSION['add_stock_error'] );
            }
            ?>
            <?php if( isset( $_SESSION['funds_error'] ) ){
               ?>
            <p><?php echo $_SESSION['funds_error']; ?></p>
            <?php
                unset( $_SESSION['funds_error'] );
            }
            ?>
            <?php if( isset( $_SESSION['portfolio_error'] ) ){
               ?>
            <p><?php echo $_SESSION['portfolio_error']; ?></p>
            <?php
                unset( $_SESSION['portfolio_error'] );
            }
            ?>   
    </div>  
    <div class="section">
        <h2>Current Holdings</h2>
        <table>
            <tr>
                <th>Symbol</th>
                <th>Company</th>
                <th>Shares<br>owned</th>
                <th>Market price<br>domestic</th>
                <th>Market price<br>foreign</th>
            </tr>
            <?php 
            foreach( $port_stocks as $cur_stock ){
                $cur_symbol = $cur_stock -> get_symbol();
                $cur_name = $cur_stock -> get_name();
                $cur_shares = $cur_stock -> get_shares_owned();
                $cur_mpd = $cur_stock -> get_domestic_f();
                $cur_mpf = $cur_stock -> get_foreign_f();
                echo "<tr>
                        <td>$cur_symbol</td>
                        <td>$cur_name</td>
                        <td>$cur_shares</td>
                        <td>$cur_mpd</td>
                        <td>$cur_mpf</td>
                     </tr>";
            }
            ?>
        </table>
    </div>
    <br>
    <div class="section">
        <h2>Rebalance Portfolio</h2>
        <form action="../controller/c_add_stock.php" method="POST">
            <h3>Add stocks</h3>
            Symbol
            <input type="text" Placeholder="Ex: AAPL" name="symbol" required/>
            Shares
            <input type="text" Placeholder="1234" name="shares" required />
            <input type="submit" value="Buy">
        </form>
        <br>
        <form action="../view/v_lots.php" method="POST">
            <h3>View Lots and sell holdings</h3>
            <input type="Submit" value="View">
        </form>
    </div>
    <br> 
    <div class="section">
        <h2>Manage Funds</h2>
        <form action="../controller/c_add_funds.php" method="POST">
            <h3>Add funds</h3>
            <p>Amount to add : </p>
            $<input type="text" placeholder="0.00" name="amount" required/>
            <input type="submit" value="Submit"/>
        </form>

        <form action="../controller/c_remove_funds.php" method="POST">
            <h3>Remove funds</h3>
            <p>Amount to remove : </p>
            $<input type="text" placeholder="0.00" name="amount" required>
            <input type="submit" value="Submit">
        </form>
    </div>
    <br>
    <div class="section">
        <h2>Functional Data</h2>
        <h3>View account records</h3>
        <form action="../view/v_records.php" method="POST">
            <input type="submit" value="View">
        </form>
    </div>
    <form action="../index.php">
        <input type="submit" value="Log Out"/>
    </form>
</div>
</html>