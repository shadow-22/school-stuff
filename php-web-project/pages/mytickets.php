<main>
  <section class="panel panel1" style="min-height: 100vh;" data-section-name="account">
      <header class="header bg-img" style="background-image: url(assets/img/parallax-blured.jpg); margin-top:0px">
        <div class="header-info h-200px mb-0">
          <div class="media align-items-end">
            <img class="avatar avatar-xl avatar-bordered" src="assets/img/avatar/1.jpg" alt="...">
            <div class="media-body">
              <p class="text-white opacity-90"><strong><?php echo escape($user->data()->username);?></strong></p>
              <p class="text-white opacity-60"><?php echo escape($user->data()->firstname);?> <?php echo escape($user->data()->secondname);?></p>
              <small class="text-white opacity-40">
                <?php
                switch ($user->data()->group) {
                  case 0:
                    echo "Διαχειριστής";
                    break;
                  case 1:
                    echo "Χρήστης";
                    break;
                  case 2:
                    echo "Πάροχος";
                    break;
                }

                 ?>
              </small>
            </div>
          </div>
        </div>

        <div class="header-action bg-white">
          <nav class="nav">
            <a class="nav-link" href="index.php?page=profile">Προεπισκοπηση</a>
            <a class="nav-link" href="index.php?page=editprofile">επεξεργασια</a>
            <a class="nav-link" href="index.php?page=changepassword">αλλαγη κωδικού</a>
            <?php if ($user->data()->group == 1) { ?>
            <a class="nav-link active" href="index.php?page=mytickets">Εισητήρια</a>
          <?php
            }
           if ($user->data()->group == 2) { ?>
          <a class="nav-link" href="index.php?page=myevents">Εκδηλώσεις</a>
        <?php } ?>
          </nav>
        </div>
      </header>




      <div class="main-content">
        <div class="row">


          <div class="col-md-8">
            <?php
              $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
          								'dbname='.Config::get('mysql/db'),
          								Config::get('mysql/username'),
          								Config::get('mysql/password'));
              $myusername = $user->data()->username;
              $stmt = $dbh->prepare("SELECT t.id, t.valid, t.number, a.eventname, a.price, a.start_date, a.end_date, a.description FROM `tickets` AS t INNER JOIN `activity` AS a ON t.activity_id = a.activity_id WHERE t.username = '$myusername'");
              $stmt->execute();
              $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);
              $total = 0;
              $valid = 0;

              foreach ($arrValues as $row){
                $total++;
                  if ($row["valid"]) {
                    $valid++; ?>
                    <div class="card bl-2 border-success">
                      <header class="card-header">
                        <h4 class="card-title"><i class="pe-7s-ticket"> </i><strong> Εκδήλωση: </strong> <?php print $row["eventname"]; ?></h4>
                        <div class="card-header-actions">
                          <a class="btn btn-sm btn-warning" href="index.php?page=event&id=<?php print $row['id'] ?>">Προβολή</a>
                          <a class="btn btn-sm btn-primary" href="pdfticket.php?id=<?php print $row['id']; ?>" target="_blank">Λήψη ως PDF</a>
                        </div>
                      </header>
                      <div class="card-body">
                        <div class="gap-items-2">
                          <strong>Αριθμός εισητηρίου: </strong><?php print $row["number"]; ?><br />
                          <strong>Ενεργό από: </strong><?php print $row["start_date"]; ?><br />
                          <strong>Ενεργό μέχρι: </strong><?php print $row["end_date"]; ?><br />
                        </div>
                      </div>
                    </div>
                  <?php
                } else { ?>
                  <div class="card bl-2 border-secondary opacity-40">
                    <header class="card-header">
                      <del><h4 class="card-title"><i class="pe-7s-ticket"> </i><strong> Εκδήλωση: </strong> <?php print $row["description"]; ?></h4></del>
                      <div class="card-header-actions">
                        <a class="btn btn-sm btn-warning" href="index.php?page=event&id=<?php print $row['id'] ?>">Προβολή</a>
                        <a class="btn btn-sm btn-primary" href="pdfticket.php?id=<?php print $row['id']; ?>" target="_blank">Λήψη ως PDF</a>
                      </div>
                    </header>
                    <div class="card-body">
                      <div class="gap-items-2">
                        <strong>Αριθμός εισητηρίου: </strong><?php print $row["number"]; ?><br />
                        <strong>Ενεργό από: </strong><?php print $row["start_date"]; ?><br />
                        <strong>Ενεργό μέχρι: </strong><?php print $row["end_date"]; ?><br />
                      </div>
                    </div>
                  </div>
                <?php
                  }
              }
            ?>

          </div>




          <div class="col-md-4">

            <div class="card">
              <div class="card-body">
                <div class="flexbox align-items-baseline mb-20">
                  <h6 class="text-uppercase ls-2">Σύνοψη</h6>
                </div>

                <div class="gap-items-2">
                  <strong> Συνολικά Εισητήρια: </strong><?php echo $total;?><br />
                  <strong>Ενεργά Εισητήρια: </strong><?php echo $valid;?><br />
                  <strong>Μη-ενεργά Εισητήρια: </strong><?php echo ($total-$valid);?><br />
                </div>
              </div>
            </div>




          </div>


        </div>
    </section>
