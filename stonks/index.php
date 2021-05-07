<?php 
  include_once 'includes/dbh.inc.php';
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Stock Portfolio</title>
  <meta name="description" content="StartScreen">
  <meta name="author" content="Steven Jacobs">

  <link rel="stylesheet" href="styles.css">

</head>

<body>
  <img src="https://s.yimg.com/ny/api/res/1.2/2YLXA9NVqMcXkcQPQD1_ZQ--/YXBwaWQ9aGlnaGxhbmRlcjt3PTk2MDtoPTU0MC40OA--/https://s.yimg.com/uu/api/res/1.2/Efm_lj_6xPRdc1CyTAcC3Q--~B/aD01NjM7dz0xMDAwO2FwcGlkPXl0YWNoeW9u/https://media.zenfs.com/en/the_motley_fool_261/0205f0fdd2ec4dd034996bb9f6ae99a5" alt="Stock Image" length = "500px" width="500px">
  
  <p><a href="stockPage.php">Stock Page</a></p>
  <p><a href="optionPage.html">Options Page</a></p>
  
  <?php
    $sql = "SELECT * FROM stock_position;"; 
    $result = mysqli_query($conn, $sql);  
    $resultCheck = mysqli_num_rows($result);
    echo $resultCheck;
    if ($resultCheck > 0) {
    }
    else {
      echo "NADA";
    }
  ?>
</body>
</html>