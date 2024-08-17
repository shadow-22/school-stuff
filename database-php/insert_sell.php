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

  if(isset($_POST['pharmacyid']))
  {
      $pharmacyid = $_POST['pharmacyid'];
  }

  if(isset($_POST['drugid']))
  {
      $drugid = $_POST['drugid'];
  }

  if(isset($_POST['price']))
  {
      $price = $_POST['price'];
  }  

  $sql = "INSERT INTO Sell
          VALUES ('$pharmacyid','$drugid','$price')";

  if (mysqli_query($conn, $sql))
  {
    echo "New sell record inserted successfully<br>";
  }
  else
  {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

mysqli_close($conn);
?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>    