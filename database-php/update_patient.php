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
      $sql = "UPDATE Patient SET PatientId = '$patientid' ";
  }
  else
  {
    echo "PatientId NOT entered!<br>";
  }

  if(isset($_POST['firstname']) && !empty($_POST['firstname']))
  {
      $firstname = $_POST['firstname'];
      $sql = "UPDATE Patient SET FirstName = '$firstname'
              WHERE PatientId = '$patientid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Patient First Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['lastname']) && !empty($_POST['lastname']))
  {
      $lastname = $_POST['lastname'];
      $sql = "UPDATE Patient SET LastName = '$lastname'
              WHERE PatientId = '$patientid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Patient Last Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['town']) && !empty($_POST['town']))
  {
      $town = $_POST['town'];
      $sql = "UPDATE Patient SET Town = '$town'
              WHERE PatientId = '$patientid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Patient town updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                          
  }

  if(isset($_POST['streetname']) && !empty($_POST['streetname']))
  {
      $streetname = $_POST['streetname'];
      $sql = "UPDATE Patient SET StreetNumber = '$streetname'
              WHERE PatientId = '$patientid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Patient street name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                      
  }

  if(isset($_POST['number']) && !empty($_POST['number']))
  {
      $number = $_POST['number'];
      $sql = "UPDATE Patient SET Number = '$number'
              WHERE PatientId = '$patientid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Patient number updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['postalcode']) && !empty($_POST['postalcode']))
  {
      $postalcode = $_POST['postalcode'];
      $sql = "UPDATE Patient SET PostalNumber = '$postalcode'
              WHERE PatientId = '$patientid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Patient postal number updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['age']) && !empty($_POST['age']))
  {
      $age = $_POST['age'];
      $sql = "UPDATE Patient SET Age = '$age'
              WHERE PatientId = '$patientid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Patient age updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }           
  }

  if(isset($_POST['doctorid']) && !empty($_POST['doctorid']))
  {
      $doctorid = $_POST['doctorid'];
      $sql = "UPDATE Patient SET DoctorId = '$doctorid'
              WHERE PatientId = '$patientid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Patient DoctorID updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }               
  }


mysqli_close($conn);

/*
  if(isset($_POST['doctorid']))
  {
      $doctorid = $_POST['doctorid'];
      $sql = "UPDATE Patient SET DoctorId = '$doctorid'
              WHERE PatientId = '$patientid' ";    
  }

  if (mysqli_query($conn, $sql))
  {
    echo "Patient record updated successfully<br>";
  }
  else
  {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

*/

?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>
