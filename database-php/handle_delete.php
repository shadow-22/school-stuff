<html>
<body>

 <?php
  if ($_POST['array'] == 'Patient')
  {
    echo 'Give Patient ID:
    <form action="delete_patient.php" method="post">
    <input type="number" name="patientid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Doctor')
  {
    echo 'Give Doctor ID:
    <form action="delete_doctor.php" method="post">
    <input type="number" name="doctorid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Pharmacy')
  {
    echo 'Give Pharmacy ID:
    <form action="delete_pharmacy.php" method="post">
    <input type="number" name="pharmacyid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Drug')
  {
    echo 'Give Drug ID:
    <form action="delete_drug.php" method="post">
    <input type="number" name="drugid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Company')
  {
    echo 'Give Company ID:
    <form action="delete_company.php" method="post">
    <input type="number" name="companyid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Sell')
  {
    echo 'Give Pharmacy ID:
    <form action="delete_sell.php" method="post">
    <input type="number" name="pharmacyid"> <br>
    Give Drug ID:<br>
    <input type="number" name="drugid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Prescription')
  {
    echo 'Give Patient ID:
    <form action="delete_prescription.php" method="post">
    <input type="number" name="patientid"> <br>
    Give Doctor ID:<br>
    <input type="number" name="doctorid"> <br>
    Give Drug ID:<br>
    <input type="number" name="drugid"> <br>
    <input type="submit">
    </form>';
  }

  if ($_POST['array'] == 'Contract')
  {
    echo 'Give Pharmacy ID:
    <form action="delete_contract.php" method="post">
    <input type="number" name="pharmacyid"> <br>
    Give Pharmaceutical Company ID:<br>
    <input type="number" name="companyid"> <br>
    <input type="submit">
    </form>';
  }

  ?>

</body>
</html>
