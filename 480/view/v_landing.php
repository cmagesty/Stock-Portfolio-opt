<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="../view/myStyle.css">
<div class="user_form">
    <h1>Portfolios</h1>
    <?php
//Author Tyler Hilsabeck
        session_start();
        if( !isset( $_SESSION['username'] ) ){
            header("Location: ../index.php");
        }
        require( "../model/User.php" );
        $username = $_SESSION['username'];
        $user = new User( $username );
        $portfolios = $user -> get_portfolios();
        ?>
    <?php
        if( count( $portfolios) > 0 ){
        ?>
        <table class="table">
        <tr>
            <th>Portfolio Name</th>
            <th>Funds</th>
        </tr>
    <?php
    foreach ( $portfolios as $cur_port ){
      $cur_funds = "\$ " . $cur_port -> get_cash();
      $cur_name = $cur_port -> get_name();
      $cur_id = $cur_port -> get_id();
      echo "<tr>
                <td>
                <a href='../view/v_portfolio.php?id=$cur_id' > " . $cur_name . " </a>
                </td>
                <td>
                " . $cur_funds . "
                </td>
            </tr>";
        }
    ?>
    </table>
    <?php 
        }
        else{
        ?>
    <h2>Looks like you don't have any portfolios.</h2>
    <h3>Create one!</h3>
    <?php
        }
        ?>
    <form action ="../controller/c_create_portfolio.php" method="POST">
        <h3>Create new portfolio</h3>
        <p>Portfolio name</p>
        <input type="text" name="port_name" required/>
        <input type ="submit" value ="Create"/>    
    </form>
    <br>
    <form action="../index.php">
        <input type="submit" value="Log Out"/>
    </form>
</div>
</html>