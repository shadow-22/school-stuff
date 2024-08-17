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
Patient (PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId)
VALUES  ('000001','Michael','Canister','New York','Trafalgar Street','452','34260','43','000002');";

if ($conn->multi_query($sql) === TRUE) {
    echo "First Original Patient record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Patient (PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId)
VALUES  ('000002','John','Canister','Atlanda','Cleopatra Street','177','38594','21','1');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Second Original Patient record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Patient (PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId)
VALUES  ('000003','Murad','Erdogan','Istanbul','Selim Street','1453','86424','79','5');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Third Original Patient record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Patient (PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId)
VALUES  ('000004','Michelle','Saradon','Los Angeles','Poker Street','423','34395','32','4');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Fourth Original Patient record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Patient (PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId)
VALUES  ('000005','Dimitris','Georgiou','Athens','Monastiraki','1821','34260','55','3')";

if ($conn->multi_query($sql) === TRUE) {
    echo "Fifth Original Patient record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

echo "<br>PHARMACY RECORDS:<br>";

mysqli_close($conn);
 ?>

</body>
</html>
