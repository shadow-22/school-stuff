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

  if(isset($_POST['name']))
  {
      $name = $_POST['name'];
  }

  if(isset($_POST['town']))
  {
      $town = $_POST['town'];
  }

  if(isset($_POST['streetname']))
  {
      $streetname = $_POST['streetname'];
  }

  if(isset($_POST['number']))
  {
      $number = $_POST['number'];
  }

  if(isset($_POST['postalcode']))
  {
      $postalcode = $_POST['postalcode'];
  }

  if(isset($_POST['phonenumber']))
  {
      $phonenumber = $_POST['phonenumber'];
  }

  $sql = "INSERT INTO Pharmacy
                 values ('$pharmacyid', '$name', '$town', '$streetname',
                         '$number', '$postalcode', '$phonenumber')";


  if (mysqli_query($conn, $sql))
  {
    echo "New record inserted successfully<br>";
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
