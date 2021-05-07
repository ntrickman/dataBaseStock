<?php 
  include_once 'includes/dbh.inc.php';
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Stock Portfolio</title>
    <meta name="description" content="StartScreen">
    <meta name="author" content="Steven Jacobs">

    <link rel="stylesheet" href="styles.css">
    <script type="text/javascript" src="scripts.js"></script>
</head>



<?php
    function getPrice($ticker) {
        $request = 'https://finance.yahoo.com/quote/'.$ticker;
        $html = file_get_contents($request);
        $start = stripos($html, 'class="Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)"');
        $end = stripos($html, '</span>', $offset = $start);
        $length = $end - $start;
        $price = substr($html, $start, $length);
        $pattern ="/>(.+)/";
        preg_match_all($pattern, $price, $matches);
        preg_match('(.+)', $matches[1][0], $match);
        $price = (float) $match[0];
        return $price;
    }

    function updatePrices() {
        $sql = "SELECT symbol FROM stock_position"; 
        $result = mysqli_query($GLOBALS['conn'], $sql);  
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $symbol = $row['symbol'];
                $price = getPrice($symbol);
                $sql = "UPDATE `stock_position` SET `curr_price`=$price WHERE symbol=\"$symbol\"";
                mysqli_query($GLOBALS['conn'], $sql);  
            }
        }
    }

    function addStockInfo($symbol) {
        $request = 'https://finance.yahoo.com/quote/'.$symbol.'/key-statistics';
        $html = file_get_contents($request);
        //PRICE
        $start = stripos($html, 'class="Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)"');
        $end = stripos($html, '</span>', $offset = $start);
        $length = $end - $start;
        $price = substr($html, $start, $length);
        $pattern ="/>(.+)/";
        preg_match_all($pattern, $price, $matches);
        preg_match('(.+)', $matches[1][0], $match);
        $price = (float) $match[0];
        //FLOAT
        $start = stripos($html, 'class="Fw(500) Ta(end) Pstart(10px) Miw(60px)"');
        $end = stripos($html, '</td>', $offset = $start);
        $length = $end - $start;
        $float = substr($html, $start, $length);
        echo $float;
        $pattern ="/>(.+)/";
        preg_match_all($pattern, $float, $matches);
        preg_match('(.+)', $matches[8][7], $match);
        $float = (float) $match[0];
        echo $float.$price;
    }

    if ($_POST['updatePrices']) {
        updatePrices();
        addStockInfo('AMD');
    }
?>

<body>
<!--<img src="" alt="Stock Image">
-->
    <div style="display:flex;">
        <button class="open-button" onclick="scripts.js/openForm('stockInput', 'optionInput')"><b>Add Stock</b></button>
        <button class="open-button" onclick="scripts.js/openForm('optionInput', 'stockInput')"><b>Add Option</b></button>
        <form display="inline" action="stockPage.php" method="post"><button  class="open-button" type="submit" name="updatePrices" value=true><b>Update Prices</b></button></form>
    </div>
    <div class="form-popup" id="stockInput">
        <form action="stockPage.php" method="post" class="form-container">
            <h1>Stock Input</h1>
            <label for="symbol"><b>Stock Symbol</b></label>
            <input type="text" name="symbol">
            <label for="qty"><b>Number of Shares</b></label>
            <input type="text" name="qty"><br>
            <label for="tradePrice"><b>Trade Price</b></label>
            <input type="text" name="tradePrice"><br>
            <label for="openDate"><b>Date Opened</b></label>
            <input type="date" name="openDate"><br>
            <button type="submit" name="so" value="stock" class="btn"><h2>Submit</h2></button>
            <button type="submit" class="btn cancel" onclick="scripts.js/closeForm('stockInput')"><h2>Close</h2></button>
        </form>
    </div>
    <div class="form-popup" id="optionInput">
        <form action="stockPage.php" method="post" class="form-container">
            <h1>Option Input</h1>
            <label for="symbol"><b>Option Symbol</b></label>
            <input type="text" name="symbol">
            <label for="qty"><b>Number of Contracts</b></label>
            <input type="text" name="qty"><br>
            <label for="tradePrice"><b>Trade Price</b></label>
            <input type="text" name="tradePrice"><br>
            <label for="openDate"><b>Date Opened</b></label>
            <input type="date" name="openDate"><br>
            <button type="submit" name="so" value="option" class="btn"><h2>Submit</h2></button>
            <button type="submit" class="btn cancel" onclick="scripts.js/closeForm('optionInput')"><h2>Close</h2></button>
        </form>
    </div>

    <?php
        if ($_POST["so"] != null) {
            $database = $_POST["so"]. '_position';
            $symbol = $_POST["symbol"];
            $quantity = $_POST["qty"];
            // $opendate = $_POST["openDate"];
            $opendate = null;
            $closedate = null;
            $tradeprice = $_POST["tradePrice"];
            $profit_loss = null;
            if ($symbol != null) {
                $currprice = getPrice($symbol);
            }
            // if ($database == 'option_position') {
                
            // }
        }

        $sql = "INSERT INTO `$database` (`symbol`, `quantity`, `curr_price`, `open_date`, `open_price`) VALUES ('$symbol', '$quantity', '$currprice', null, '$tradeprice')"; 
        mysqli_query($conn, $sql); 


        $sql = "SELECT * FROM stock_position"; 
        $result = mysqli_query($conn, $sql);  
        echo "<h1>Stocks</h1>";
        if ($result->num_rows > 0) {
            // output data of each row
            echo "<table class='styled-table'>";
            echo "<tr><td width=150px>symbol</td><td>quantity</td><td>price</td><td>open_date</td><td>open_price</td><td>profit_loss</td></tr>\n";

            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['symbol']."</td><td>".$row['quantity']."</td><td>$".$row['curr_price']."</td><td>".$row['open_date']."</td><td>$".$row['open_price']."</td><td>$".$row['profit_loss']."</td></tr>\n";
            }
            echo "</table>";
        }

        $sql = "SELECT * FROM option_position"; 
        $result = mysqli_query($conn, $sql);  
        echo "<h1>Options</h1>";
        if ($result->num_rows > 0) {
            // output data of each row
            echo "<table class='styled-table'>";
            echo "<tr><td width=150px>symbol</td><td>quantity</td><td>open_date</td><td>open_price</td></tr>\n";

            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['symbol']."</td><td>".$row['quantity']."</td><td>".$row['open_date']."</td><td>".$row['open_price']."</td></tr>\n";
            }
            echo "</table>";
        }
    ?>

    <!-- <button id="test" onclick="test()">Test</button> -->
    <!-- <script>
        function test() {
            
            var symbol = document.getElementsByName("symbol")[0].value;
            var qty = document.getElementsByName("qty")[0].value;
            var tradePrice = document.getElementsByName("tradePrice")[0].value;
            var openDate = document.getElementsByName("openDate")[0].value;
            // if (tradePrice == null) {
            //     tradePrice = yahooStockPrices.getCurrentData(symbol);
            // }
            document.write("Symbol: ", symbol);
            document.write("<br>Quantiy: ", qty);
            document.write("<br>Trade Price: ", tradePrice);
            document.write("<br>Dated Opened: ", openDate);
            
            
        }
    </script>  -->

    <!-- <p id="addStock" onclick="addStock()">Add Stock</p>

    <script>
        var name = "";
        var shares = 0;
        
        function addStock() {
        name = prompt("Stock Name:","GME")
        shares = prompt("Number of shares:", "0");
        }
    </script> -->

    <p id="blank"></p>

</body>
</html>