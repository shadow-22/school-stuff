<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "210";

//create connection
$conn = mysqli_connect($servername, $username, $password);
//check connection
if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error() . "<br>");
}

//create database
$sql = "CREATE database ergasia_db";
if (mysqli_query($conn, $sql))
{
  echo "Database created successfully<br>";
}
else
{
  echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, 'ergasia_db');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}

 $conn->close();;

 ?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>

