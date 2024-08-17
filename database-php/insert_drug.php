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

  if(isset($_POST['drugid']))
  {
      $drugid = $_POST['drugid'];
  }

  if(isset($_POST['name']))
  {
      $name = $_POST['name'];
  }

  if(isset($_POST['formula']))
  {
      $formula = $_POST['formula'];
  }

  if(isset($_POST['companyid']))
  {
      $companyid = $_POST['companyid'];
  }  


  $sql = "INSERT INTO Drug
          VALUES ('$drugid','$name','$formula','$companyid')";

  if (mysqli_query($conn, $sql))
  {
    echo "New drug record inserted successfully<br>";
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