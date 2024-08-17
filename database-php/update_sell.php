<html>
<body>

  <?php
  $servername = "localhost";
  $username = "root";
  $password = "210";
  $dbname = "ergasia_db";

  //create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  //check connection
  if (!$conn)
  {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
  }

  if(isset($_POST['pharmacyid']) && !empty($_POST['pharmacyid']))
  {
      $pharmacyid = $_POST['pharmacyid'];
//      $sql = "UPDATE Sell SET PharmacyId = '$pharmacyid' ";
  }

  if(isset($_POST['drugid']) && !empty($_POST['drugid']) && !empty($_POST['pharmacyid']))
  {
      $drugid = $_POST['drugid'];
      $sql = "UPDATE Sell SET PharmacyId = '$pharmacyid' ";  
      mysqli_query($conn, $sql);          
      $sql = "UPDATE Sell SET DrugId = '$drugid' ";
      mysqli_query($conn, $sql); 

      if(isset($_POST['price']) && !empty($_POST['price']))
      {
      $price = $_POST['price'];
      $sql = "UPDATE Sell SET Price = '$price'
              WHERE DrugId = '$drugid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
        {
           echo "Sell Price updated successfully<br>";
        }
      else
        {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }                        
      }
  }
  else
  {
    echo "PharmacyID or DrugID NOT entered!<br>";
  }
/*
  if(isset($_POST['price']) && !empty($_POST['price']))
  {
      $price = $_POST['price'];
      $sql = "UPDATE Sell SET Price = '$price'
              WHERE DrugId = '$drugid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Sell Price updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }
*/
mysqli_close($conn);  

?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>    