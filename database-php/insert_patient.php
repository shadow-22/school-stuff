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

  if(isset($_POST['firstname']))
  {
      $firstname = $_POST['firstname'];
  }

  if(isset($_POST['lastname']))
  {
      $lastname = $_POST['lastname'];
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

  if(isset($_POST['age']))
  {
      $age = $_POST['age'];
  }

  if(isset($_POST['doctorid']))
  {
      $doctorid = $_POST['doctorid'];
  }

  $sql = "INSERT INTO Patient
                 values ('$patientid', '$firstname', '$lastname', '$town', '$streetname',
                         '$number', '$postalcode', '$age', '$doctorid')";

  if (mysqli_query($conn, $sql))
  {
    echo "New patient record inserted successfully<br>";
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
