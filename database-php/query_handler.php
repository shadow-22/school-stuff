<html>
<body>

  <?php

   if ($_POST['query'] == 'q1')
   {
     echo             
    '<form action="sql1.php" method="post">
     Insert Patient ID:
     <input type="number" name="patientid"> <br>
     <input type="submit" name="Submit">
     </form>';
     // emfanizei ta perioxomena tou asthenh
   }

   if ($_POST['query'] == 'q2')
   {
     echo               
    '<form action="sql2.php" method="post">
     Insert Town of Pharmacies:
     <input type="text" name="pharmacy_town"> <br>
     <input type="submit" name="Submit">
     </form>';
     // emfanizei ola ta farmakeias ths polhs
   }

   if ($_POST['query'] == 'q3')
   {
     echo 
    '<form action="sql3.php" method="post">
     Insert Phamaceutical Company ID:
     <input type="number" name="pharm_comp_id"> <br>
     <input type="submit" name="Submit">
     </form>';
     // emfanizei to thlefwnoths farmakeutikhs etaireias
   }

   if ($_POST['query'] == 'q4')
   {
     include "sql4.php";  
     // emfanizei thn mesh hlikia twn asthenwn
   }

    if ($_POST['query'] == 'q5')
    {
      include "sql5.php";  
      // group by tous giatrous ana eidikothta
    }

    if ($_POST['query'] == 'q6')
    {
      include "sql6.php";  
      // order by tous giatrous ana xronia empeirias
    }

    if ($_POST['query'] == 'q7')
    {
      include "sql7.php";  
      // group by ta tous giatrous ana eidikothta kai having
      // exp.years > 20
    }

    if ($_POST['query'] == 'q8')
    {
     echo             
    '<form action="sql8.php" method="post">
     Insert Patient ID:
     <input type="number" name="patientid"> <br>
     <input type="submit" name="Submit">
     </form>';
      // emfanizei ola ta farmaka pou pairnei
      // enas asthenhs
    }

    if ($_POST['query'] == 'q9')
    {
      echo 
      '<form action="sql9.php" method="post">
      Insert Pharmacy ID:
      <input type="number" name="pharmacyid"> <br>
      <input type="submit" name="Submit">
       </form>';
     // emfanizei ola ta farmaka pou poulaei 
     // ena farmakeio
    }

    if ($_POST['query'] == 'q10')
    {
      require "sql10.php";
      // nested query
    }

   ?>
</body>
</html>
