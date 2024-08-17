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
//******************************************************************************
// FIRST RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000001','Pfizer','2104582364') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000002','Novartis','2104853478') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Second Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000003','Roche','2105364789') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Third Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000004','Sanofi','2109463127') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fourth Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000005','Takeda','2104972610') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fifth Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SIXTH RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000006','Lilly','2100196743') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Sixth Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SEVENTH RECORD
$sql = "INSERT INTO
PharmaceuticalCompany (PharmaceuticalCompanyId,Name,PhoneNumber)
VALUES ('000007','AbbVie Inc.','4208996712') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Seventh Original Pharmaceutical Company record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

echo "<br>DRUG RECORDS:<br>";

mysqli_close($conn);
 ?>