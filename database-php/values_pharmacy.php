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
Pharmacy (PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber)
VALUES ('000001','Mixelogiannakis','Hrakleio','Venizelos Street','1453','10150','345869741')";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Pharmacy record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Pharmacy (PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber)
VALUES ('000002','Dourou','Athina','Eleutheria Street','1922','16120','34748641')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Second Original Pharmacy record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Pharmacy (PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber)
VALUES ('000003','Voutsis','Athina','Proedros Street','1955','19110','84748644')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Third Original Pharmacy record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Pharmacy (PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber)
VALUES ('000004','Tsakalotos','Athina','Mnhmonio Street','1974','25467','42718649')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fourth Original Pharmacy record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Pharmacy (PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber)
VALUES ('000005','Tsipras','Athina','Denlewpsemmata Street','2015','55466','71748230')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fifth Original Pharmacy record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SIXTH RECORD
$sql = "INSERT INTO
Pharmacy (PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber)
VALUES ('000006','Varoufakis','Hrakleio','LitosVios Street','2015','35466','67728232')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Sixth Original Pharmacy record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
echo "<br>PHARMACEUTICAL COMPANY:<br>";
mysqli_close($conn);
 ?>