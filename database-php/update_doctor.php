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

  if(isset($_POST['doctorid']) && !empty($_POST['doctorid']))
  {
      $doctorid = $_POST['doctorid'];
      $sql = "UPDATE Doctor SET DoctorId = '$doctorid' ";
  }
  else
  {
    echo "DoctorId NOT entered!<br>";
  }

  if(isset($_POST['firstname']) && !empty($_POST['firstname']))
  {
      $firstname = $_POST['firstname'];
      $sql = "UPDATE Doctor SET FirstName = '$firstname'
              WHERE DoctorId = '$doctortid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Doctor First Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['lastname']) && !empty($_POST['lastname']))
  {
      $lastname = $_POST['lastname'];
      $sql = "UPDATE Doctor SET LastName = '$lastname'
              WHERE DoctorId = '$doctorid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Doctor Last Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }  

  if(isset($_POST['speciality']) && !empty($_POST['speciality']))
  {
      $speciality = $_POST['speciality'];
      $sql = "UPDATE Doctor SET Speciality = '$speciality'
              WHERE DoctorId = '$doctortid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Doctor Speciality updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['experienceyears']) && !empty($_POST['experienceyears']))
  {
      $experienceyears = $_POST['experienceyears'];
      $sql = "UPDATE Doctor SET ExperienceYears = '$experienceyears'
              WHERE DoctorId = '$doctorid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Doctor Experience Years updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }    


mysqli_close($conn);  

?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>