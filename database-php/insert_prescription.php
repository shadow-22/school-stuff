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

  if(isset($_POST['patientid']))
  {
      $patientid = $_POST['patientid'];
  }

  if(isset($_POST['doctorid']))
  {
      $doctorid = $_POST['doctorid'];
  }

  if(isset($_POST['drugid']))
  {
      $drugid = $_POST['drugid'];
  }

  if(isset($_POST['quantity']))
  {
      $quantity = $_POST['quantity'];
  }    

  $sql = "INSERT INTO Prescription
          VALUES ('$patientid','$doctorid','$drugid','$quantity')";

  if (mysqli_query($conn, $sql))
  {
    echo "New Prescription record inserted successfully<br>";
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