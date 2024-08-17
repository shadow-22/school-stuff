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

  $del_id = $_POST['drugid'];

  $sql = "DELETE FROM Drug WHERE DrugId = $del_id";

  if (mysqli_query($conn, $sql)) {
      echo "Drug Record deleted successfully<br>";
  } else {
      echo "Error deleting Drug record: " . mysqli_error($conn);
  }

  mysqli_close($conn);
  ?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>  