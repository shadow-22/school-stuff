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

  if(isset($_POST['companyid']) && !empty($_POST['companyid']) && isset($_POST['pharmacyid']) && !empty($_POST['pharmacyid']))
  {
      $companyid = $_POST['companyid'];
      $sql = "UPDATE Contract SET PharmacyId = '$pharmacyid' ";  
      mysqli_query($conn, $sql); 
      $sql = "UPDATE Contract SET PharmaceuticalCompanyId = '$companyid' ";
      mysqli_query($conn, $sql);

      if(isset($_POST['startdate']) && !empty($_POST['startdate']))
      {
      $startdate = $_POST['startdate'];
      $sql = "UPDATE Contract SET StartDate = '$startdate'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
        {
          echo "Contract StartDate updated successfully<br>";
        }
      else
        {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }                        
      }
// yparxei eidiko eidos metavlhths gia dates...
  if(isset($_POST['enddate']) && !empty($_POST['enddate']))
  {
      $enddate = $_POST['enddate'];
      $sql = "UPDATE Contract SET EndDate = '$enddate'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract EndDate updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }
// sto text mporw na allaksw to form gia na einai swstotero
  if(isset($_POST['text']) && !empty($_POST['text']))
  {
      $text = $_POST['text'];
      $sql = "UPDATE Contract SET Text = '$text'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract Text updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['supervisor']) && !empty($_POST['supervisor']))
  {
      $supervisor = $_POST['supervisor'];
      $sql = "UPDATE Contract SET Supervisor = '$supervisor'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract Supervisor updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }      
  }
  else
  {
    echo "PharmacyID or CompanyID NOT entered!<br>";
  }
  /*
// tha mporousa na valw ta epomena mesa sto apo panw if gia na sigourepsw oti o xrhsths dinei to primary key
  if(isset($_POST['startdate']) && !empty($_POST['startdate']))
  {
      $startdate = $_POST['startdate'];
      $sql = "UPDATE Contract SET StartDate = '$startdate'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract StartDate updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }
// yparxei eidiko eidos metavlhths gia dates...
  if(isset($_POST['enddate']) && !empty($_POST['enddate']))
  {
      $enddate = $_POST['enddate'];
      $sql = "UPDATE Contract SET EndDate = '$enddate'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract EndDate updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }
// sto text mporw na allaksw to form gia na einai swstotero
  if(isset($_POST['text']) && !empty($_POST['text']))
  {
      $text = $_POST['text'];
      $sql = "UPDATE Contract SET Text = '$text'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract Text updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['supervisor']) && !empty($_POST['supervisor']))
  {
      $supervisor = $_POST['supervisor'];
      $sql = "UPDATE Contract SET Supervisor = '$supervisor'
              WHERE PharmaceuticalCompanyId = '$companyid'
              AND PharmacyId = '$pharmacyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Contract Supervisor updated successfully<br>";
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