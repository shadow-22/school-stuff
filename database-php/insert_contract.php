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

  if(isset($_POST['companyid']))
  {
      $companyid = $_POST['companyid'];
  }

  if(isset($_POST['startdate']))
  {
      $startdate = $_POST['startdate'];
  }

  if(isset($_POST['enddate']))
  {
      $enddate = $_POST['enddate'];
  } 

  if(isset($_POST['text']))
  {
      $text = $_POST['text'];
  }

  if(isset($_POST['supervisor']))
  {
      $supervisor = $_POST['supervisor'];
  }  

  $sql = "INSERT INTO Contract
          VALUES ('$pharmacyid','$companyid','$startdate','$enddate','$text','$supervisor')";

  if (mysqli_query($conn, $sql))
  {
    echo "New Contract record inserted successfully<br>";
  }
  else
  {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn). "<br>";
  }

mysqli_close($conn);
?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>           