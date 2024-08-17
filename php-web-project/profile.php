<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Team Null.">
  <meta name="keywords" content="dashboard, index, main">

  <title>Team Null.</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300" rel="stylesheet">
  <!-- Styles -->
  <link href="styles/core.min.css" rel="stylesheet">
  <link href="styles/basics.css" rel="stylesheet">
  <link href="styles/navbar.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">
  <link href="styles/parallax.css" rel="stylesheet">
  <link href="styles/eleni.css" rel="stylesheet">
</head>
<body data-provide="pace">
  <!-- Preloader -->
  <div class="preloader">
    <div class="spinner-dots">
      <span class="dot1"></span>
      <span class="dot2"></span>
      <span class="dot3"></span>
    </div>
  </div>
  <section class="panel headersec" data-section-name="header">
    <header class="topbar topbar-expand-lg bb-1 border-secondary">
      <div class="topbar-left">
        <span class="topbar-btn topbar-menu-toggler"><i>&#9776;</i></span>
        <span class="topbar-brand"><img src="assets/img/logo.png" alt="logo-icon" style="height:45px;"></span>

        <div class="topbar-divider d-none d-xl-block"></div>

        <nav class="topbar-navigation">
          <ul class="menu">

            <li class="menu-item active">
              <a class="menu-link no-underline" href="index.php">
                <span class="pe-7s-home pe-lg pe-va"></span>
                <span class="title">Αρχική</span>
              </a>
            </li>

            <li class="menu-item">
              <a class="menu-link no-underline" href="#">
                <span class="pe-7s-albums pe-lg pe-va"></span>
                <span class="title">Κατηγορίες</span>
              </a>
            </li>

            <li class="menu-item">
              <a class="menu-link no-underline" href="#">
                <span class="pe-7s-help1 pe-lg pe-va"></span>
                <span class="title">Πως λειτουργεί;</span>
              </a>
            </li>

          </ul>
        </nav>
      </div>


      <div class="topbar-right">
        <a class="topbar-btn no-underline" href="#qv-global" data-toggle="quickview"><i class="pe-7s-more pe-lg"></i></a>
        <div class="topbar-divider d-none d-xl-block"></div>
        <ul class="topbar-btns">
          <li class="dropdown">
            <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="gatos.jpg" width="20" height="20" style="border-radius: 20px" alt="..."></span>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item no-underline" href="profile.php"><i class="pe-7s-user pe-lg"></i> Προφίλ</a>
              <a class="dropdown-item no-underline" href="#"><i class="pe-7s-wallet pe-lg"></i> Πορτοφόλι</a>
		<a class="dropdown-item no-underline" href="update.php"><i class="pe-7s-tools pe-lg"></i> Επεξεργασία λογαριασμού</a>
              <div class="dropdown-divider no-underline"></div>
              <a class="dropdown-item no-underline" href="logout.php"><i class="pe-7s-power pe-lg"></i> Έξοδος</a>
            </div>
          </li>


          <!-- Notifications -->
          <li class="dropdown d-none d-md-block">
            <span class="topbar-btn has-new" data-toggle="dropdown"><i class="pe-7s-bell pe-lg"></i></span>
            <div class="dropdown-menu dropdown-menu-right">

              <div class="media-list media-list-hover media-list-divided media-sm">
                <a class="media media-new no-underline" href="#">
                  <span class="avatar bg-success"><i class="ti-user"></i></span>
                  <div class="media-body">
                    <p>Νέος πάροχος εγγράφτηκε</p>
                    <time datetime="2017-07-14 20:00">Μόλις τώρα</time>
                  </div>
                </a>

                <a class="media no-underline" href="#">
                  <span class="avatar bg-pale-success"><i class="ti-face-smile"></i></span>
                  <div class="media-body">
                    <p>Δημιουργίθηκε νέα εκδήλωση</p>
                    <time datetime="2017-07-14 20:00">πριν 24 λεπτά</time>
                  </div>
                </a>

                <a class="media no-underline" href="#">
                  <span class="avatar bg-primary"><i class="ti-money"></i></span>
                  <div class="media-body">
                    <p>Έγινε νέα πληρωμή</p>
                    <time datetime="2017-07-14 20:00">πριν 53 λεπτά</time>
                  </div>
                </a>
              </div>

              <div class="dropdown-footer">
                <div class="left">
                  <a href="#">Ανάγνωση όλων των ειδοποιήσεων</a>
                </div>

                <div class="right">
                  <a href="#" data-provide="tooltip" title="Μαρκάρισμα όλων ως διαβασμένα"><i class="fa fa-circle-o no-underline"></i></a>
                  <a href="#" data-provide="tooltip" title="Ενημέρωση"><i class="fa fa-repeat no-underline"></i></a>
                </div>
              </div>

            </div>
          </li>
          <!-- END Notifications -->
        </ul>


      </div>
    </header>
  </section>

  <!-- END Topbar -->

  <main>
    <div class="parallax" id="#home">
    <section class="panel panel1" style="min-height: 100vh;" data-section-name="update">
      <div class="main-content center-v">

          <section style="margin-top:100px">
		<ins>
            <h1 id="p5"> Προσωπικά Στοιχεία Λογαριασμού</h1>
		</ins>

	<div style="margin-top:60px">
	<div class="column L">
		<img src="gatos.jpg" alt="profile photo" width="300" height="300" style="border-radius: 10px">
	</div>

	<div class="column R" >
	    <i>
            <ul id="p7">
            <li><strong>username:<?php echo escape($user->data()->username);?><strong></li>
            <li>Όνομα:<?php echo escape($user->data()->firstname);?></li>
            <li>Επίθετο:<?php echo escape($user->data()->secondname);?></li>
            <li>email:<?php echo escape($user->data()->email);?></li>
            </ul>
           </i>
	</div>
	</div>
         </section>



      </div>
    </section>
</div>
  </main>


  <section class="panel footersec pt-50" data-section-name="footer">
    <div class="footersec">
      <footer class="site-footer pb-20">
        <div class="row gap-y">
          <div class="col-lg-7">
            <h5 class="fs-16 ls-1">Σχετικά με το Project</h5>
            <p>
              Στο πλαίσιο του μαθήματος "Τεχνολογία Λογισμικού", της σχολής Ηλεκτρολώγων Μηχανικών και Μηχανικών Υπολογιστών, του Εθνικού Μετσόβιου Πολυτεχνείου, αναπτύχθηκε αυτή η πλατφόρμα.
            </p>
            <p>
              Αυτή η διαδικτυακή πλατφόρμα βοηθάει τους γονείς να επιλέξουν δραστηριότητες για τα παιδιά τους. Η πλατφόρμα μας απευθύνεται σε γονείς και τους παρέχει μια εύκολη, γρήγορη και ασφαλή δυνατότητα να αναζητούν, να ενημερώνονται σχετικά με προσφερόμενες υπηρεσίες για τα παιδιά τους καθώς και να αγοράζουν εισιτήρια συμμετοχής σε αυτές. Αυτό γίνεται μέσα από ένα αποτελεσματικό και γρήγορο μηχανισμό ο οποίος παρέχει σύνθετη αναζήτηση με πληθώρα κριτηρίων. Επιπλέον, η πλατφόρμα μας απευθύνεται και σε παρόχους δραστηριοτήτων, οι οποίοι αναζητούν πελάτες για να πουλήσουν τις υπηρεσίες τους. Με αυτό τον τρόπο καλύπτουμε ανάγκες προώθησης και πώλησης των υπηρεσιών τους ενώ ταυτόχρονα βοηθάμε τους γονείς να επιλέξουν τις ιδανικές δραστηριότητες για τα παιδιά τους.
            </p>
          </div>

          <div class="col-9 col-md-9 col-lg-2 text-left1 text-lg-center1">
            <h5 class="fs-16 ls-1">Team Null.</h5>
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="#">Σχετικά με την εργασία</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Πως λειτουργεί;</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Όροι Χρήσης</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Πολιτική Προσωπικών Δεδομένων</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Επικοινωνία μαζί μας</a>
              </li>
            </ul>
          </div>

          <div class="col-md-6 col-lg-3 text-left1 text-lg-center1">
            <h5 class="fs-16 ls-1">Newsletter</h5>
            <p><strong>Εγγραφή</strong> στο newsletter μας:</p>
            <br>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Διεύθυνση email...">
            </div>
            <button class="btn btn-primary btn-block" type="button"><i class="fa fa-paper-plane"></i> Εγγραφή</button>
          </div>

        </div>
        <hr />
        <div class="row">
          <div class="col-md-12 center-h">
            <p>Copyright © 2018 <strong>Τζιρής Νικόλαος</strong>, <strong>Τσίκο Δήμητρα</strong>, <strong>Ησαΐας Βρακίδης</strong>, <strong>Κατάρα Αντωνία-Ραφαέλα</strong>, <strong>Κατσαρός Περικλής</strong>, <strong>Καρανικόλα Ελένη</strong>. All rights reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  </section>
  </main>


<!-- Global quickview -->
<div id="qv-global" class="quickview" data-url="pages/adv_search.php">
  <div class="spinner-linear">
    <div class="line"></div>
  </div>
</div>
<!-- END Global quickview -->

<!-- Scripts -->
<script src="assets/js/core.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/script.js"></script>
<script type="text/javascript" src="assets/js/jquery.scrollify.js"></script>
</body>
</html>
