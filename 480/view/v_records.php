<!DOCTYPE html> 
<link rel="stylesheet" type="text/css" href="../view/myStyle.css">
<?php
//Author: Tyler Hilsabeck
require_once( "../model/Sale_record.php" );
require_once( "../model/Purchase_record.php" );
require_once( "../model/Cash_record.php" );
session_start();
$c_record = new Cash_record( null );
$p_record = new Purchase_record();
$s_record = new Sale_record();
$c_records = $c_record -> get_all_records();
$p_records = $p_record -> get_all_records();
$s_records = $s_record -> get_all_records();
?>
<div class="user_form">
    <h1>Records</h1>
    <div class="section">
        <h2>Cash Transactions</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Transaction</th>
                <th>Amount</th>
            </tr>
            <?php 
            foreach( $c_records as $record ){
                $cur_date = $record[0];
                $cur_trans = $record[1];
                $cur_amount = $record[2];
                echo 
                "<tr>
                        <td>$cur_date</td>
                        <td>$cur_trans</td>
                        <td>$cur_amount</td>
                </tr>";
            }
            ?>
        </table>
    </div>
    <br>
    <div class="section">
        <h2>Stock Purchases</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Share Price</th>
                <th>Total Purchase</th>
            </tr>
            <?php
            foreach( $p_records as $record ){
                $cur_date = $record[0];
                $cur_symbol = $record[1];
                $cur_shares = $record[2];
                $cur_sp = $record[3];
                $cur_tp = $record[4];
                echo 
                "<tr>
                        <td>$cur_date</td>
                        <td>$cur_symbol</td>
                        <td>$cur_shares</td>
                        <td>$cur_sp</td>
                        <td>$cur_tp</td>
                </tr>";
            }
            ?>
        </table>
    </div>
    <br>
    <div class="section">
        <h2>Stock Sales</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Purchase Date</th>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Purchase Price</th>
                <th>Sell Price</th>
                <th>Total Sale</th>
            </tr>
            <?php
            foreach( $s_records as $record ){
                $cur_date = $record[0];
                $cur_pd = $record[1];
                $cur_symbol = $record[2];
                $cur_shares = $record[3];
                $cur_pp = $record[4];
                $cur_sp = $record[5];
                $cur_tt = $record[6];
                echo 
                "<tr>
                        <td>$cur_date</td>
                        <td>$cur_pd</td>
                        <td>$cur_symbol</td>
                        <td>$cur_shares</td>
                        <td>$cur_pp</td>
                        <td>$cur_sp</td>
                        <td>$cur_tt</th>
                </tr>";
            }
            ?>
        </table>
    </div>
    <br>
    <form action="../controller/c_download_records.php">
        <input type="submit" value="Download report">
    </form>
    <form action="../view/v_portfolio.php">
        <input type="submit" value="Return to portfolio page">
    </form>
</div>
</html>


