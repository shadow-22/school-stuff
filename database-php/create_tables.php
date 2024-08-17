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
    die("Connection failed: " . mysqli_connect_error(). "<br>");
}

//creating tables
$sql1 = "CREATE table Doctor (
  DoctorId int(6) UNSIGNED primary key,
  FirstName varchar(30) not null,
  LastName varchar(30) not null,
  Speciality varchar(30) not null,
  ExperienceYears int(3) UNSIGNED not null
  )";

  if (mysqli_query($conn, $sql1)) {
      echo "Table Doctor created successfully<br>";
  } else {
      echo "Error creating table Doctor: " . mysqli_error($conn). "<br>";
  }


$sql2 = "CREATE table Patient (
  PatientId int(6) UNSIGNED PRIMARY KEY not null,
  FirstName varchar(30) not null,
  LastName varchar(30) not null,
  Town varchar(30) not null,
  StreetNumber varchar(30) not null,
  Number varchar(30) not null,
  PostalNumber varchar(30) not null,
  Age int(3) UNSIGNED null,
  DoctorId int(6) UNSIGNED not null,
  foreign key(DoctorId) REFERENCES Doctor(DoctorId)
  on delete cascade
  /*on update cascade*/
  )";

  if (mysqli_query($conn, $sql2)) {
      echo "Table Patient created successfully<br>";
  } else {
      echo "Error creating table Patient: " . mysqli_error($conn). "<br>";
  }

$sql3 = "CREATE table PharmaceuticalCompany (
  PharmaceuticalCompanyId int(6) UNSIGNED primary key,
  Name varchar(30) not null,
  PhoneNumber int(10) UNSIGNED not null
  )";

  if (mysqli_query($conn, $sql3)) {
      echo "Table PharmaceuticalCompany created successfully<br>";
  } else {
      echo "Error creating table PharmaceuticalCompany: " . mysqli_error($conn) . "<br>";
  }

$sql4 = "CREATE table Drug (
  DrugId int(6) UNSIGNED primary key,
  Name varchar(30) not null,
  Formula varchar(30) not null,
  PharmaceuticalCompanyId int(6) UNSIGNED not null,
  foreign key(PharmaceuticalCompanyId) REFERENCES PharmaceuticalCompany(PharmaceuticalCompanyId)
  on delete cascade
  /*on update cascade*/
  )";

  if (mysqli_query($conn, $sql4)) {
      echo "Table Drug created successfully<br>";
  } else {
      echo "Error creating table Drug: " . mysqli_error($conn) . "<br>";
  }

$sql5 = "CREATE table Pharmacy (
  PharmacyId int(6) UNSIGNED primary key,
  Name varchar(30) not null,
  Town varchar(30) not null,
  StreetName varchar(30) not null,
  Number varchar(30) not null,
  PostalCode varchar(30) not null,
  PhoneNumber varchar(30) not null
  )";

  if (mysqli_query($conn, $sql5)) {
      echo "Table Pharmacy created successfully<br>";
  } else {
      echo "Error creating table Pharmacy: " . mysqli_error($conn) . "<br>";
  }

$sql6 = "CREATE table Sell(
  PharmacyId int(6) UNSIGNED not null,
  DrugId int(6) UNSIGNED  not null,
  primary key(PharmacyId,DrugId),
  Price int(5) UNSIGNED not null,
  foreign key(PharmacyId) REFERENCES Pharmacy(PharmacyId)
  on delete cascade
  /*on update cascade*/,
  foreign key(DrugId) REFERENCES Drug(DrugId)
  on delete cascade
  /*on update cascade*/
  )";

  if (mysqli_query($conn, $sql6)) {
      echo "Table Sell created successfully<br>";
  } else {
      echo "Error creating table Sell: " . mysqli_error($conn) . "<br>";
  }

$sql7 = "CREATE table Prescription(
  PatientId int(6) UNSIGNED not null,
  DoctorId int(6) UNSIGNED not null,
  DrugId int(6) UNSIGNED not null,
  primary key(PatientId,DoctorId,DrugId),
  Date varchar(30) not null,
  Quantity int(3) not null,
  foreign key(PatientId) REFERENCES Patient(PatientId)
  on delete cascade
  /*on update cascade*/,
  foreign key(DoctorId) REFERENCES Doctor(DoctorId)
  on delete cascade
  /*on update cascade*/,
  foreign key(DrugId) REFERENCES Drug(DrugId)
  on delete cascade
  /*on update cascade*/
  )";

  if (mysqli_query($conn, $sql7)) {
      echo "Table Prescription created successfully<br>";
  } else {
      echo "Error creating table Prescription: " . mysqli_error($conn) . "<br>";
  }

$sql8 = "CREATE table Contract(
  PharmacyId int(6) UNSIGNED not null,
  PharmaceuticalCompanyId int(6) UNSIGNED not null,
  primary key(PharmacyId,PharmaceuticalCompanyId),
  StartDate varchar(30) not null,
  EndDate varchar(30) not null,
  Text varchar(90) not null,
  Supervisor varchar(30) not null,
  foreign key(PharmacyId) REFERENCES Pharmacy(PharmacyId)
  on delete cascade
  /*on update cascade*/,
  foreign key(PharmaceuticalCompanyId) REFERENCES PharmaceuticalCompany(PharmaceuticalCompanyId)
  on delete cascade
  /*on update cascade*/
  )";

  if (mysqli_query($conn, $sql8)) {
      echo "Table Contract created successfully<br>";
  } else {
      echo "Error creating table Contract: " . mysqli_error($conn) . "<br>";
  }

 // include "first_trigger.php";

 mysqli_close($conn);


/*
$sql7 = "CREATE table Prescription(
  PatientId int(6) UNSIGNED auto_increment primary key,
  DoctorId int(6) UNSIGNED not null,
  DrugId int(6) UNSIGNED not null,
  Date varchar(30) not null,
  Quantity int(3) not null,
  foreign key(DoctorId) REFERENCES Doctor(DoctorId)
  on delete cascade
  on update cascade,
  foreign key(DrugId) REFERENCES Drug(DrugId)
  on delete cascade
  on update cascade
  )";
*/
 ?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>


</body>
</html>


