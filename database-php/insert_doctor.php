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

  if(isset($_POST['doctorid']))
  {
      $doctorid = $_POST['doctorid'];
  }

  if(isset($_POST['firstname']))
  {
      $firstname = $_POST['firstname'];
  }

  if(isset($_POST['lastname']))
  {
      $lastname = $_POST['lastname'];
  }

  if(isset($_POST['speciality']))
  {
      $speciality = $_POST['speciality'];
  }

  if(isset($_POST['experienceyears']))
  {
      $experienceyears = $_POST['experienceyears'];
  }
  
  @sum;
  $sql1 = "SET @sum = 0";
  mysqli_query($conn,$sql1);

  $sql =  "INSERT INTO Doctor
                     values ('$doctorid', '$firstname', '$lastname',
                             '$speciality', '$experienceyears') ";

  if (mysqli_query($conn, $sql))
  {
  echo "New Doctor record inserted successfully<br>";
  }
  else
  {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br><br>";
  }

$sql = "SELECT @sum AS 'TOTAL' ";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
    echo "Total: " . $row["Total"] . "<br><br>";
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
