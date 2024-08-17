<main>
  <section class="panel panel1" style="min-height: 100vh;" data-section-name="account">
    <div class="main-content" style="margin-top: 50px;">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <div class="flexbox align-items-baseline mb-20">
                <h6 class="text-uppercase ls-2">Εκδήλωση:</h6>
              </div>

              <div class="gap-items-2">
  <?php
  if (isset($_GET['id'])) {
      $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
                  'dbname='.Config::get('mysql/db'),
                  Config::get('mysql/username'),
                  Config::get('mysql/password'));
      $myid = $user->data()->id;
      $stmt = $dbh->prepare("SELECT * FROM activity where activity_id =".$_GET['id']."");
      $stmt->execute();
      $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($arrValues as $row){
        echo "<br>". "Όνομα Εκδήλωσης: " . $row["eventname"];
        echo "<br>". "Όνομα Παρόχου: " . $row["pr_name"]. " ". $row["pr_surname"];
        echo "<br>". "Τιμή: " . $row["price"];
        echo "<br>". "Κατώτατη Ηλικία: " . $row["age_low"];
        echo "<br>". "Ανώτατη Ηλικία: " . $row["age_high"];
        echo "<br>". "Ημερομηνία Έναρξης: " . $row["start_date"];
        echo "<br>". "Ημερομηνία Λήξης: " . $row["end_date"];
        echo "<br>". "Ώρα Έναρξης: " . $row["start_time"];
        echo "<br>". "Ώρα Λήξης: " . $row["end_time"];
        echo "<br>". "Απόθεμα Εισητηρίων: ". $row["ticket_stock"];
        echo "<br>". "Τύπος Δραστηριότητας: " . $row["type"];
        echo "<br>". "Σύντομη Περιγραφή: " . $row["description"];
        echo "<br>". "Παραπάνω Στοιχεία: " . $row["long_description"];
        ?>

</div>
</div>

</div>


</div>





<div class="col-md-4">

  <div class="card">
    <div class="card-body">
      <div class="flexbox align-items-baseline mb-20">
        <h6 class="text-uppercase ls-2">Αγορά</h6>
      </div>

      <div class="gap-items-2">
        <?php if ($user->data()->group == 1) { ?>
        <strong>Εισητήριο για την εκδήλωση: </strong><?php echo $row["price"];?> Null Coins<br />

        <br />
        <form  method = "post" action = '<?php echo "removepoints.php"; ?>'>
          <input type="hidden" name="activity_id" value="<?php echo $_GET['id']; ?>" />
          <input type="hidden" name="pointsToRemove" value="<?php echo $row["price"]; ?>"/>
          <input type="submit" class="btn btn-lg btn-block btn-success" name="pay" value="Πληρωμή" />
      	</form>
        <?php } ?>
      </div>
    </div>
    <?php if ($user->data()->group == 1) { ?>
    <div class="text-center bt-1 border-light p-12">
      <a class="text-uppercase d-block fs-10 fw-500 ls-1 text-light cursor-pointer" data-dismiss="modal" data-provide="modaler" data-url="buy_points.php" data-is-modal="true">Αγορα Null Coins</a>
    </div>
    <?php } ?>
  </div>




</div>
</div>


</div>
<?php }
} else {
echo "0 results";
}
?> ?>
</section>
