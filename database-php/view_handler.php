<html>
<body>

<?php

if ($_POST['view'] == 'patient_view')
{
	include "view_patient.php";
}

if ($_POST['view'] == 'doctor_view')
{
	include "view_doctor.php";
}

if ($_POST['view'] == 'pharmacy_view')
{
	include "view_pharmacy.php";
}

if ($_POST['view'] == 'company_view')
{
	include "view_company.php";
}

if ($_POST['view'] == 'drug_view')
{
	include "view_drug.php";
}

if ($_POST['view'] == 'sell_view')
{
	include "view_sell.php";
}

if ($_POST['view'] == 'prescription_view')
{
	include "view_prescription.php";
}

if ($_POST['view'] == 'contract_view')
{
	include "view_contract.php";
}

if ($_POST['view'] == 'Npatient_view')
{
	include "view_Npatient.php";
}

?>

</body>
</html>