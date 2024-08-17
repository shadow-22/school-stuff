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

  $del_pid = $_POST['pharmacyid'];
  $del_cid = $_POST['companyid'];

  $sql = "DELETE FROM Sell WHERE PharmacyId = $del_pid
          AND PharmaceuticalCompanyId = $del_cid";

  if (mysqli_query($conn, $sql)) {
      echo "Contract Record deleted successfully<br>";
  } else {
      echo "Error deleting Contract record: " . mysqli_error($conn);
  }

  mysqli_close($conn);
  ?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>   