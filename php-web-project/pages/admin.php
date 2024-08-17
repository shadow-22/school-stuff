<?php
  // Admin Check
  if((!$user->isLoggedIn()) || !($user->data()->group == 0)) {
    Redirect::to('index.php');
  }

 ?>
<main>
  <section class="panel panel1 center-h" style="min-height: 60vh; margin-top:100px;" data-section-name="account">
    <div class="card" style="width:95vw;">
      <h4 class="card-title">Πίνακας <strong>Διαχειριστή</strong></h4>

      <div class="card-body">
        <div class="nav-tabs-left">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-tabs-primary">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#admin-users">Διαχείριση Χρηστών</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#admin-events">Διαχείριση Εκδηλώσεων</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content" style="width:100%">
            <div class="tab-pane fade active show" id="admin-users">





              <div class="media-list media-list-divided media-list-hover">

                <div class="media-list-body bg-white b-1">
                  <?php
                  $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
              								'dbname='.Config::get('mysql/db'),
              								Config::get('mysql/username'),
              								Config::get('mysql/password'));
                  $myusername = $user->data()->username;
                  $stmt = $dbh->prepare("SELECT * FROM `users`");
                  $stmt->execute();
                  $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($arrValues as $row) {
                   ?>
                  <div class="media align-items-center">
                  <?php if ($row["group"] == 0) { ?>
                    <span class="badge badge-ring badge-danger mr-1"></span>
                    <small>Διαχειριστής </small>
                  <?php }
                        if ($row["group"] == 1) { ?>
                    <span class="badge badge-ring badge-primary mr-1"></span><small>Χρήστης</small>
                  <?php }
                        if ($row["group"] == 2) { ?>
                    <span class="badge badge-ring badge-warning mr-1"></span><small>Πάροχος</small>
                  <?php } ?>


                    <a class="flexbox flex-grow gap-items text-truncate no-underline">
                      <?php if ($row["group"] == 0) { ?>
                      <span> </span><span></span><span></span>
                    <?php } else { ?>
                      <span></span><span></span><span></span><span></span>
                    <?php } ?>

                      <div class="media-body text-truncate">
                        <h6><?php print $row["username"]; ?></h6>

                        <small>
                          <span><?php print $row["firstname"]; ?> <?php print $row["secondname"]; ?></span>
                        </small>
                      </div>
                    </a>

                    <div class="dropdown">
                      <a class="btn btn-sm dropdown-toggle" data-toggle="dropdown" href="#">Αλλαγή ρόλου σε:</a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="index.php?page=changeuser&uname=<?php print  $row["username"]; ?>&role=1"><span class="badge badge-ring badge-primary mr-1"></span> Χρήστη</a>
                        <a class="dropdown-item" href="index.php?page=changeuser&uname=<?php print  $row["username"]; ?>&role=2"><span class="badge badge-ring badge-warning mr-1"></span> Πάροχο</a>
                        <a class="dropdown-item" href="index.php?page=changeuser&uname=<?php print  $row["username"]; ?>&role=0"><span class="badge badge-ring badge-danger mr-1"></span> Διαχειριστή</a>
                      </div>
                    </div>
                    <a class="btn btn-sm btn-warning">Password Resset</a>
                    <a class="btn btn-sm btn-danger" href="index.php?page=deleteuser&uname=<?php print  $row["username"]; ?>">Διαγραφή</a>
                  </div>
                <?php } ?>
                </div>
              </div><br /><br /><br /><br /></div>
              <div class="tab-pane fade" id="admin-events">
                <div class="media-list media-list-divided media-list-hover">

                  <div class="media-list-body bg-white b-1">
                    <?php
                      $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
                  								'dbname='.Config::get('mysql/db'),
                  								Config::get('mysql/username'),
                  								Config::get('mysql/password'));
                      $myid = $user->data()->id;
                      $stmt = $dbh->prepare("SELECT * FROM `activity`");
                      $stmt->execute();
                      $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($arrValues as $row){ ?>
                    <div class="media align-items-center">

                      <a class="flexbox flex-grow gap-items text-truncate no-underline" href="#qv-user-details">


                        <div class="media-body text-truncate">
                          <h6><strong> Εκδήλωση: </strong> <?php print $row["description"]; ?></h6>

                          <small>
                            <strong>Ενεργό από: </strong><?php print $row["start_time"]; ?><br />
                            <strong>Ενεργό μέχρι: </strong><?php print $row["end_time"]; ?><br />
                          </small>
                        </div>
                      </a>

                      <a class="btn btn-sm btn-warning" href="index.php?page=event&id=<?php print $row['activity_id']; ?>">Προβολή</a>
                      <a class="btn btn-sm btn-danger" href="index.php?page=deleteevent&id=<?php print $row['activity_id']; ?>">Διαγραφή</a>
                    </div>
                  <?php } ?>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
