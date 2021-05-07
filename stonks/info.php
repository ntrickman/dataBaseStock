<?php 
  include_once 'includes/dbh.inc.php';
?>

<html>
<head>
    <meta charset="utf-8">

    <title>Stock Portfolio</title>
    <meta name="description" content="StartScreen">
    <meta name="author" content="Steven Jacobs">

    <link rel="stylesheet" href="styles.css" >
</head>

<body>

<?php
    $symbol = $_POST["symbol"];
    $quantity = $_POST["qty"];
    // $opendate = $_POST["openDate"];
    $opendate = null;
    $closedate = null;
    $tradeprice = $_POST["tradePrice"];
    $closeprice = null;
    $profit_loss = null;


    $sql = "INSERT INTO `stock_position` (`symbol`, `quantity`, `open_date`, `close_date`, `open_price`, `close_price`, `profit_loss`) VALUES ('$symbol', '$quantity', null, null, '50', null, null)"; 
    echo "YO";
    mysqli_query($conn, $sql);  

    $sql = "SELECT * FROM stock_position"; 
    $result = mysqli_query($conn, $sql);  
    if ($result->num_rows > 0) {
        // output data of each row
        echo "<table class='styled-table'>";
        echo "<tr><td>symbol</td><td>quantity</td><td>open_date</td><td>open_price</td></tr>\n";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row['symbol']."</td><td>".$row['quantity']."</td><td>".$row['open_date']."</td><td>".$row['open_price']."</td></tr>\n";
        }
        echo "</table>";
    }

?>
<!-- Stock: <?php echo $_POST["symbol"]; ?><br>
Quanity: <?php echo $_POST["qty"]; ?>

<?php
if ($_POST["openDate"] == NULL) {
    $_POST["openDate"] = date("Y-m-d");
}
echo $_POST["openDate"];
?> -->
</body>
</html>