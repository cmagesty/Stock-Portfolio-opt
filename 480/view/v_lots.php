<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="../view/myStyle.css">
<?php 
//Author: Tyler Hilsabeck
    require( "../model/Lot.php" );
    require_once( "../model/Portfolio.php" );
    session_start();
    $port_id = $_SESSION['port_id'];
    $port = new Portfolio();
    $port -> instantiate( $port_id );
    $port_name = $port -> get_name();
    $lots = $port -> get_lots();
    ?>
<div class="user_form">
    <h1><?php echo $port_name?> Lots</h1>
        <div class="error">
            <?php if( isset( $_SESSION['sell_error'] ) ){
               ?>
            <p class="error"><?php echo $_SESSION['sell_error']; ?></p>
            <?php
                unset( $_SESSION['sell_error'] );
            }
            ?>
        </div>    
    <h2>Select a lot to sell from</h2>
    <div class="section">
        <form action="../controller/c_remove_stock.php" method="POST">
            <table>
                <tr>
                    <th>Selection</th>
                    <th>Symbol</th>
                    <th>Company</th>
                    <th>Shares</th>
                    <th>Purchase Date</th>
                    <th>Purchase Price<br>domestic</th>
                    <th>Market price<br>domestic</th>
                    <th>Purchase Price<br>foreign</th>
                    <th>Market price<br>foreign</th>
                </tr>
                <?php 
                foreach( $lots as $cur_lot ){
                    //make sure to test that there are enough stocks in the lot to sell
                    $cur_id = $cur_lot -> get_lot_id();
                    $cur_symbol = $cur_lot -> get_symbol();
                    $cur_name = $cur_lot -> get_name();
                    $cur_shares = $cur_lot -> get_shares();
                    $cur_purchase_date = $cur_lot -> get_purchase_date();
                    $cur_ppd = $cur_lot -> get_domestic_purchase();
                    $cur_mpd = $cur_lot -> get_domestic_cur();
                    $cur_ppf = $cur_lot -> get_foreign_purchase();
                    $cur_mpf = $cur_lot -> get_foreign_cur();
                    echo 
                    "<tr>
                            <td><input type=\"radio\" name=\"lot_id\" value=\"$cur_id\"></td>
                            <td>$cur_symbol</td>
                            <td>$cur_name</td>
                            <td>$cur_shares</td>
                            <td>$cur_purchase_date</td>
                            <td>$cur_ppd</td>
                            <td>$cur_mpd</td>
                            <td>$cur_ppf</td>
                            <td>$cur_mpf</td>
                         </tr>";
                }
                ?>
            </table>
            <p>Shares to sell</p>
            <input type="text" name="shares" Placeholder="1234" required>
            <input type="submit" value="Sell">
        </form>
        <br>
        <form action="../view/v_portfolio.php">
            <input type="submit" value="Return to portfolio page">
        </form>
    </div>
</div>
</html>
