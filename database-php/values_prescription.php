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
Prescription (PatientId,DoctorId,DrugId,Date,Quantity)
VALUES ('000001','000002','000001','13/9/2001','3') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Prescription record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Prescription (PatientId,DoctorId,DrugId,Date,Quantity)
VALUES ('000002','000001','000003','8/2/2001','2') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Second Original Prescription record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Prescription (PatientId,DoctorId,DrugId,Date,Quantity)
VALUES ('000003','000005','000002','2/3/2001','1') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Third Original Prescription record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Prescription (PatientId,DoctorId,DrugId,Date,Quantity)
VALUES ('000004','000004','000006','29/1/2001','5') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fourth Original Prescription record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Prescription (PatientId,DoctorId,DrugId,Date,Quantity)
VALUES ('000005','000003','000004','21/3/2001','2') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fifth Original Prescription record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//****************************************************************************
// SIXTH RECORD -// tha to parei akyro, prepei na kanw composite primary key(patientid,doctorid,drugid) ston pinaka prescription sto create_tables.php
$sql = "INSERT INTO
Prescription (PatientId,DoctorId,DrugId,Date,Quantity)
VALUES ('000001','000002','000005','18/5/2001','4') ";

if ($conn->multi_query($sql) === TRUE) {
    echo " Sixth Original Prescription record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
echo "<br>SELL RECORDS:<br>";
mysqli_close($conn);


/*
$sql = "INSERT INTO Prescription
VALUES 
('000001','000002','000001','13/9/2001','3'),
('000002','000001','000003','8/2/2001','2'),
('000003','000005','000002','2/3/2001','1'),
('000004','000004','000006','29/1/2001','5'),
('000005','000003','000004','21/3/2001','2');";
*/


?>