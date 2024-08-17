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

  if(isset($_POST['patientid']) && !empty($_POST['patientid']))
  {
      $patientid = $_POST['patientid'];
  }

  if(isset($_POST['doctorid']) && !empty($_POST['doctorid']))
  {
    $doctorid = $_POST['doctorid'];
  }
  

  if(isset($_POST['drugid']) && !empty($_POST['drugid']) && isset($_POST['doctorid']) && !empty($_POST['doctorid']) && isset($_POST['patientid']) && !empty($_POST['patientid']))
  {
    $drugid = $_POST['drugid'];
    $sql = "UPDATE Prescription SET DrugId = '$drugid' ";
    mysqli_query($conn, $sql);
    $sql = "UPDATE Prescription SET DoctorId = '$doctorid' ";
    mysqli_query($conn, $sql);
    $sql = "UPDATE Prescription SET PatientId = '$patientid' ";
    mysqli_query($conn, $sql);

    if (isset($_POST['quantity']) && !empty($_POST['quantity']))
    {
      $quantity = $_POST['quantity'];
      $sql = "UPDATE Prescription SET Quantity = '$quantity' ";
      mysqli_query($conn, $sql);
    }

    if (isset($_POST['date']) && !empty($_POST['date']))
    {
      $date = $_POST['date'];
      $sql = "UPDATE Prescription SET Date = '$date' ";
      mysqli_query($conn, $sql);
    }
     echo "Prescription record updated!<br><br>";
  }
  else
  {
    echo "PatientID or DoctorId or DrugID NOT entered!<br>";
  }

  mysqli_close($conn);  

  ?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>    