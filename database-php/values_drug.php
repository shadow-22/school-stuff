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
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000001','Viagra','Sildenafil Citrate','000001') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000002','Humira','Adalimumab','000007') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Second Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000003','Mabthera','Rituximab','000003') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Third Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000004','Votubia','Everolimus','000002') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fourth Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000005','Enbrel','Etanercept','000001') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fifth Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SIXTH RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000006','Takecab','Vonoprazan','000005') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Sixth Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SEVENTH RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000007','Effient','Prasugrel','000006') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Seventh Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// EIGHTH RECORD
$sql = "INSERT INTO
Drug (DrugId,Name,Formula,PharmaceuticalCompanyId)
VALUES ('000008','Aubagio','Teriflunomide','000004') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Eighth Original Drug record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

echo "<br>PRESCRIPTION RECORDS:<br>";

mysqli_close($conn);

/*
$sql = "INSERT INTO Drug
VALUES
('000001','Viagra','Sildenafil Citrate','000001'),
('000002','Humira','Adalimumab','000007'),
('000003','Mabthera','Rituximab','000003')
('000004','Votubia','Everolimus','000002'),
('000005','Enbrel','Etanercept','000001'),
('000006','Takecab','Vonoprazan','000005'),
('000007','Effient','Prasugrel','000006'),
('000008','Aubagio','Teriflunomide','000004');"; 
*/

?>