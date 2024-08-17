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

  if(isset($_POST['drugid']) && !empty($_POST['drugid']))
  {
      $drugid = $_POST['drugid'];
      $sql = "UPDATE Drug SET DrugId = '$drugid' ";
      mysqli_query($conn, $sql);

  if(isset($_POST['name']) && !empty($_POST['name']))
  {
      $name = $_POST['name'];
      $sql = "UPDATE Drug SET Name = '$name'
              WHERE DrugId = '$drugid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Drug Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['formula']) && !empty($_POST['formula']))
  {
      $formula = $_POST['formula'];
      $sql = "UPDATE Drug SET Town = '$formula'
              WHERE DrugId = '$drugid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Drug Formula updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['companyid']) && !empty($_POST['companyid']))
  {
      $companyid = $_POST['companyid'];
      $sql = "UPDATE Drug SET StreetName = '$companyid'
              WHERE DrugId = '$drugid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Drug PharmaceuticalCompanyID updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                          
  }
  }
  else
  {
    echo "DrugID NOT entered!<br>";
  }
/*
  if(isset($_POST['name']) && !empty($_POST['name']))
  {
      $name = $_POST['name'];
      $sql = "UPDATE Drug SET Name = '$name'
              WHERE DrugId = '$drugid' ";

      if (mysqli_query($conn, $sql))
      {
         echo "Drug Name updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                     
  }

  if(isset($_POST['formula']) && !empty($_POST['formula']))
  {
      $formula = $_POST['formula'];
      $sql = "UPDATE Drug SET Town = '$formula'
              WHERE DrugId = '$drugid' ";  

      if (mysqli_query($conn, $sql))
      {
         echo "Drug Formula updated successfully<br>";
      }
      else
      {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }                        
  }

  if(isset($_POST['companyid']) && !empty($_POST['companyid']))
  {
      $companyid = $_POST['companyid'];
      $sql = "UPDATE Drug SET StreetName = '$companyid'
              WHERE DrugId = '$drugid' "; 

      if (mysqli_query($conn, $sql))
      {
         echo "Drug PharmaceuticalCompanyID updated successfully<br>";
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