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
  
  $sql = "DELETE FROM Patient";

  if (mysqli_query($conn, $sql)) {
      echo "Table Patient deleted successfully<br>";
  } else {
      echo "Error deleting table Patient: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Patient AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Patient reseted successfully<br><br>";
  } else {
      echo "Error reseting table Patient: " . mysqli_error($conn). "<br><br>";
  }
//*************DOCTOR*****************************************

    $sql = "DELETE FROM Doctor";

  if (mysqli_query($conn, $sql)) {
      echo "Table Doctor deleted successfully<br>";
  } else {
      echo "Error deleting table Doctor: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Doctor AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Doctor reseted successfully<br><br>";
  } else {
      echo "Error reseting table Doctor: " . mysqli_error($conn). "<br><br>";
  }

//****************PHARMACY**********************************


  $sql = "DELETE FROM Pharmacy";

  if (mysqli_query($conn, $sql)) {
      echo "Table Pharmacy deleted successfully<br>";
  } else {
      echo "Error deleting table Pharmacy: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Pharmacy AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Pharmacy reseted successfully<br><br>";
  } else {
      echo "Error reseting table Pharmacy: " . mysqli_error($conn). "<br><br>";
  }


  //************DRUG***************************************


    $sql = "DELETE FROM Drug";

  if (mysqli_query($conn, $sql)) {
      echo "Table Drug deleted successfully<br>";
  } else {
      echo "Error deleting table Drug: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Drug AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Drug reseted successfully<br><br>";
  } else {
      echo "Error reseting table Drug: " . mysqli_error($conn). "<br><br>";
  }


//*****************COMPANY********************************


  $sql = "DELETE FROM PharmaceuticalCompany";

  if (mysqli_query($conn, $sql)) {
      echo "Table PharmaceuticalCompany deleted successfully<br>";
  } else {
      echo "Error deleting table PharmaceuticalCompany: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE PharmaceuticalCompany AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table PharmaceuticalCompany reseted successfully<br><br>";
  } else {
      echo "Error reseting table PharmaceuticalCompany: " . mysqli_error($conn). "<br><br>";
  }


  //****************SELL*********************************

    $sql = "DELETE FROM Sell";

  if (mysqli_query($conn, $sql)) {
      echo "Table Sell deleted successfully<br>";
  } else {
      echo "Error deleting table Sell: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Sell AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Sell reseted successfully<br><br>";
  } else {
      echo "Error reseting table Sell: " . mysqli_error($conn). "<br><br>";
  }


  //****************PRESCRIPTION***************************


    $sql = "DELETE FROM Prescription";

  if (mysqli_query($conn, $sql)) {
      echo "Table Prescription deleted successfully<br>";
  } else {
      echo "Error deleting table Prescription: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Prescription AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Prescription reseted successfully<br><br>";
  } else {
      echo "Error reseting table Prescription: " . mysqli_error($conn). "<br><br>";
  }


  //******************CONTRACT****************************

    $sql = "DELETE FROM Contract";

  if (mysqli_query($conn, $sql)) {
      echo "Table Contract deleted successfully<br>";
  } else {
      echo "Error deleting table Contract: " . mysqli_error($conn). "<br>";
  }

  $sql = "ALTER TABLE Contract AUTO_INCREMENT = 1";

  if (mysqli_query($conn, $sql)) {
      echo "Table Contract reseted successfully<br><br>";
  } else {
      echo "Error reseting table Contract: " . mysqli_error($conn). "<br><br>";
  }  



  ?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>