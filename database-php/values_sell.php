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
Sell (PharmacyId,DrugId,Price)
VALUES ('000001','000002','20')";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000002','000001','50')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Second Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000003','000003','15')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Third Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000004','000005','25')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fourth Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000005','000004','30')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fifth Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SIXTH RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000006','000002','20')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Sixth Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SEVENTH RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000003','000001','50')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Seventh Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// EIGHTH RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000001','000005','25')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Eighth Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// Ninth RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000004','000006','75')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Ninth Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// Tenth RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000006','000008','150')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Tenth Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// Eleventh RECORD
$sql = "INSERT INTO
Sell (PharmacyId,DrugId,Price)
VALUES ('000005','000007','50')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Eleventh Original Sell record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

echo "<br>CONTRACT RECORDS:<br>";

mysqli_close($conn);

?>