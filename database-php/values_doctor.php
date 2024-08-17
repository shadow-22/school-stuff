<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "210";
$dbname = "ergasia_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
//*****************************************************************************
// FIRST RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000001','Trevor','Philipps','Cardiology','30');";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000002','Carl','Johnson','Brain Tumors','13');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Second Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000003','Bob','Curry','Athletics','20');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Third Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000004','Homer','Georgapoulos','Neurology','35');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Fourth Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000005','Gregori','Petkov','Dentist','5');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Fifth Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SIXTH RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000006','Friedrich','Van Basten','Cardiology','40');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Sixth Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SEVENTH RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000007','Pablo','Picasso','Dentist','50');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Seventh Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// EIGHTH RECORD
$sql = "INSERT INTO
Doctor  (DoctorId,FirstName,LastName,Speciality,ExperienceYears)
VALUES  ('000008','Richard','Geers','Neurology','20');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Eighth Original Doctor record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
echo "<br>PATIENT RECORDS:<br>";
mysqli_close($conn);
 ?>

</body>
</html>
