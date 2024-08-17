<html>
<body>

<?php

if ($_POST['array'] == 'Patient')
{
  echo 'Insert new data
  <form action="update_patient.php" method="post">
  Patient ID<br>
  <input type="number" name="patientid"> <br>
  First Name<br>
  <input type="text" name="firstname"> <br>
  Last Name<br>
  <input type="text" name="lastname"> <br>
  Town<br>
  <input type="text" name="town"> <br>
  StreetName<br>
  <input type="text" name="streetname"> <br>
  Number<br>
  <input type="text" name="number"> <br>
  PostalCode<br>
  <input type="text" name="postalcode"> <br>
  Age<br>
  <input type="number" name="age"> <br>
  DoctorId<br>
  <input type="number" name="doctorid"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Doctor')
{
  echo 'Insert new data
  <form action="update_doctor.php" method="post">
  Doctor ID<br>
  <input type="number" name="doctorid"> <br>
  First Name<br>
  <input type="text" name="firstname"> <br>
  Last Name<br>
  <input type="text" name="lastname"> <br>
  Speciality<br>
  <input type="text" name="speciality"> <br>
  Experience Years<br>
  <input type="number" name="experienceyears"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Pharmacy')
{
  echo 'Insert new data
  <form action="update_pharmacy.php" method="post">
  Pharmacy ID<br>
  <input type="number" name="pharmacyid"> <br>
  Name<br>
  <input type="text" name="name"> <br>
  Town<br>
  <input type="text" name="town"> <br>
  StreetName<br>
  <input type="text" name="streetname"> <br>
  Number<br>
  <input type="text" name="number"> <br>
  PostalCode<br>
  <input type="text" name="postalcode"> <br>
  PhoneNumber<br>
  <input type="text" name="phonenumber"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Drug')
{
  echo 'Insert new data
  <form action="update_drug.php" method="post">
  Drug ID<br>
  <input type="number" name="drugid"> <br>
  Name<br>
  <input type="text" name="name"> <br>
  Formula<br>
  <input type="text" name="formula"> <br>
  Pharmaceutical Company ID<br>
  <input type="number" name="companyid"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Company')
{
  echo 'Insert new data
  <form action="update_company.php" method="post">
  Pharmaceutical Company ID<br>
  <input type="number" name="companyid"> <br>
  Name<br>
  <input type="text" name="name"> <br>
  Phone Number<br>
  <input type="number" name="phonenumber"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Sell')
{
  echo 'Insert new data
  <form action="update_sell.php" method="post">
  Pharmacy ID<br>
  <input type="number" name="pharmacyid"> <br>
  DrugID<br>
  <input type="number" name="drugid"> <br>
  Price<br>
  <input type="number" name="price"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Prescription')
{
  echo 'Insert new data
  <form action="update_prescription.php" method="post">
  Patient ID<br>
  <input type="number" name="patientid"> <br>
  Doctor ID<br>
  <input type="number" name="doctorid"> <br>
  Drug ID<br>
  <input type="number" name="drugid"> <br>
  Quantity<br>
  <input type="number" name="quantity"> <br>
  Date<br>
  <input type="varchar" name="date"> <br>
  <input type="submit">
  </form>';
}

if ($_POST['array'] == 'Contract')
{
  echo 'Insert new data
  <form action="update_contract.php" method="post">
  Pharmacy ID<br>
  <input type="number" name="pharmacyid"> <br>
  Pharmaceutical Company ID<br>
  <input type="number" name="companyid"> <br>
  Start Date<br>
  <input type="text" name="startdate"> <br>
  End Date<br>
  <input type="text" name="enddate"> <br>
  Text<br>
  <input type="text" name="text"> <br>
  Supervisor<br>
  <input type="text" name="supervisor"> <br>
  <input type="submit">
  </form>';
}



 ?>

</body>
</html>