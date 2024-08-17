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

    if(isset($_POST['companyid']) && !empty($_POST['companyid']))
  {
      $companyid = $_POST['companyid'];
      $sql = "UPDATE PharmaceuticalCompany SET PharmaceuticalCompanyId = '$companyid' ";
  }
  else
  {
    echo "PharmaceuticalCompanyId NOT entered!<br>";
  }

  if(isset($_POST['name']) && !empty($_POST['name']))
  {
      $name = $_POST['name'];
      $sql = "UPDATE PharmaceuticalCompany SET Name = '$name'
              WHERE PharmaceuticalCompanyId = '$companyid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "PharmaceuticalCompany Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['phonenumber']) && !empty($_POST['phonenumber']))
  {
      $phonenumber = $_POST['phonenumber'];
      $sql = "UPDATE PharmaceuticalCompany SET PhoneNumber = '$phonenumber'
              WHERE PharmaceuticalCompanyId = '$companyid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "PharmaceuticalCompany PhoneNumber updated successfully<br>";
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