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
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000001','000007','1/3/1999','23/4/2004','Contract is between Pharmacy-Mixelogiannakis and Company-AbbVie','W.Schauble')";

if ($conn->multi_query($sql) === TRUE) {
    echo " First Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SECOND RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000002','000001','4/8/1998','15/2/2003','Contract is between Pharmacy-Dourou and Company-Pfizer','A.Merkel')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Second Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// THIRD RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000003','000003','8/3/1997','7/3/2002','Contract is between Pharmacy-Voutsis and Company-Roche','F.Monderini')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Third Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FOURTH RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000004','000001','14/9/1999','1/8/2005','Contract is between Pharmacy-Tsakalotos and Company-Pfizer','D.Trump')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fourth Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// FIFTH RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000005','000002','27/5/1997','27/3/2002','Contract is between Pharmacy-Tsipras and Company-Novartis','V.Putin')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Fifth Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SIXTH RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000006','000007','5/12/1999','5/12/2005','Contract is between Pharmacy-Varoufakis and Company-AbbVie','T.May')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Sixth Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// SEVENTH RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000004','000005','9/11/1998','20/7/2003','Contract is between Pharmacy-Tsakalotos and Company-Takeda','L.Yagami')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Seventh Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// EIGHTH RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000006','000004','16/10/1997','2/1/2002','Contract is between Pharmacy-Varoufakis and Company-Sanofi','Ryuzaki')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Eighth Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
//*****************************************************************************
// NINTH RECORD
$sql = "INSERT INTO
Contract (PharmacyId,PharmaceuticalCompanyId,StartDate,EndDate,Text,SuperVisor)
VALUES ('000005','000006','11/7/1995','25/12/2005','Contract is between Pharmacy-Tsipras and Company-Lilly','R.T.Erdogan')";

if ($conn->multi_query($sql) === TRUE) {
    echo " Ninth Original Contract record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

echo "<br><br>";

mysqli_close($conn);

?>