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
      $sql = "UPDATE Pharmacy SET PharmacyId = '$pharmacyid' ";
      mysqli_query($conn, $sql); 

  if(isset($_POST['name']) && !empty($_POST['name']))
  {
      $name = $_POST['name'];
      $sql = "UPDATE Pharmacy SET Name = '$name'
              WHERE PharmacyId = '$pharmacyid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['town']) && !empty($_POST['town']))
  {
      $town = $_POST['town'];
      $sql = "UPDATE Pharmacy SET Town = '$town'
              WHERE PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Town updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['streetname']) && !empty($_POST['streetname']))
  {
      $streetname = $_POST['streetname'];
      $sql = "UPDATE Pharmacy SET StreetName = '$streetname'
              WHERE PharmacyId = '$pharmacyid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Street Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                          
  }

  if(isset($_POST['number']) && !empty($_POST['number']))
  {
      $number = $_POST['number'];
      $sql = "UPDATE Pharmacy SET Number = '$number'
              WHERE PharmacyId = '$pharmacyid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Number updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                      
  }

  if(isset($_POST['postalcode']) && !empty($_POST['postalcode']))
  {
      $postalcode = $_POST['postalcode'];
      $sql = "UPDATE Patient SET PostalCode = '$postalcode'
              WHERE PharmacyId = '$pharmacyid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Postal Code updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['phonenumber']) && !empty($_POST['phonenumber']))
  {
      $phonenumber = $_POST['phonenumber'];
      $sql = "UPDATE Pharmacy SET PhoneNumber = '$phonenumber'
              WHERE PharmacyId = '$pharmacyid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Phone Number updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  }
  else
  {
    echo "PharmacyId NOT entered!<br>";
  }
/*
  if(isset($_POST['name']) && !empty($_POST['name']))
  {
      $name = $_POST['name'];
      $sql = "UPDATE Pharmacy SET Name = '$name'
              WHERE PharmacyId = '$pharmacyid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['town']) && !empty($_POST['town']))
  {
      $town = $_POST['town'];
      $sql = "UPDATE Pharmacy SET Town = '$town'
              WHERE PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Town updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['streetname']) && !empty($_POST['streetname']))
  {
      $streetname = $_POST['streetname'];
      $sql = "UPDATE Pharmacy SET StreetName = '$streetname'
              WHERE PharmacyId = '$pharmacyid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Street Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                          
  }

  if(isset($_POST['number']) && !empty($_POST['number']))
  {
      $number = $_POST['number'];
      $sql = "UPDATE Pharmacy SET Number = '$number'
              WHERE PharmacyId = '$pharmacyid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Number updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                      
  }

  if(isset($_POST['postalcode']) && !empty($_POST['postalcode']))
  {
      $postalcode = $_POST['postalcode'];
      $sql = "UPDATE Patient SET PostalCode = '$postalcode'
              WHERE PharmacyId = '$pharmacyid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Postal Code updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['phonenumber']) && !empty($_POST['phonenumber']))
  {
      $phonenumber = $_POST['phonenumber'];
      $sql = "UPDATE Pharmacy SET PhoneNumber = '$phonenumber'
              WHERE PharmacyId = '$pharmacyid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Pharmacy Phone Number updated successfully<br>";
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