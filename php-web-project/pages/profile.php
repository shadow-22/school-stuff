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
            <a class="nav-link active" href="index.php?page=profile">Προεπισκοπηση</a>
            <a class="nav-link" href="index.php?page=editprofile">επεξεργασια</a>
            <a class="nav-link" href="index.php?page=changepassword">αλλαγη κωδικού</a>
            <?php if ($user->data()->group == 1) { ?>
            <a class="nav-link" href="index.php?page=mytickets">Εισητήρια</a>
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

            <div class="card">
              <div class="card-body">
                <div class="flexbox align-items-baseline mb-20">
                  <h6 class="text-uppercase ls-2">Το προφίλ μου:</h6>
                </div>

                <div class="gap-items-2">
                  <strong>Username: </strong><?php echo escape($user->data()->username);?><br />
                  <strong>Όνομα: </strong><?php echo escape($user->data()->firstname);?><br />
                  <strong>Επίθετο: </strong><?php echo escape($user->data()->secondname);?><br />
                  <strong>Email: </strong><?php echo escape($user->data()->email);?><br />
                  <strong>Ημερομηνία εγγραφής: </strong><?php echo escape($user->data()->joined);?><br />
                  <strong>Διεύθυνση: </strong><?php echo escape($user->data()->home1);?>, <?php echo escape($user->data()->home2);?> <br />
                  <strong>Πόλη: </strong><?php echo escape($user->data()->city);?><br />
                  <strong>Νομός: </strong><?php echo escape($user->data()->state);?><br />
                  <strong>Ταχ. Κώδικας: </strong><?php echo escape($user->data()->zip);?><br />
                </div>
              </div>
              <div class="text-center bt-1 border-light p-12">
                <a class="text-uppercase d-block fs-10 fw-500 ls-1 text-light" href="index.php?page=editprofile">Επεξεργασια</a>
              </div>
            </div>


          </div>




          <div class="col-md-4">

            <div class="card">
              <div class="card-body">
                <div class="flexbox align-items-baseline mb-20">
                  <h6 class="text-uppercase ls-2">Σύνοψη</h6>
                </div>

                <div class="gap-items-2">
                  <?php if ($user->data()->group == 1) { ?>
                  <strong>Πορτοφόλι: </strong><?php echo escape($user->data()->wallet);?> Null Coins<br />
                  <?php
                    }
                   if ($user->data()->group == 2) { ?>
                     <strong>Κέρδος: </strong><?php echo escape($user->data()->wallet);?> €<br />
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
    </section>
