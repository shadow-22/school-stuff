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
              <a class="menu-link no-underline" href="#">
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
        <?php require_once 'core/init.php';
        if(Session::exists('home'))
         {
           echo '<p>' .Session::flash('home').'</p>';
         }


           $user = new User();

           if($user->isLoggedIn()) {
           ?>
        <a class="topbar-btn no-underline" href="#qv-global" data-toggle="quickview"><i class="pe-7s-more pe-lg"></i></a>
        <div class="topbar-divider d-none d-xl-block"></div>
           <li class="menu-item active">
             <a class="menu-link no-underline" href="#">
               <span class="title">Hello,<?php echo escape($user->data()->username); ?></span>
             </a>
           </li>
        <ul class="topbar-btns">
          <li class="dropdown">
            <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="assets/img/avatar/1.jpg" alt="..."></span>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item no-underline" href="profile.php"><i class="pe-7s-user pe-lg"></i> Προφίλ</a>
              <a class="dropdown-item no-underline" href="#"><i class="pe-7s-wallet pe-lg"></i> Πορτοφόλι</a>
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
        <?php
          } else {
       ?>
          <div><button class="btn btn-outline btn-primary" data-provide="modaler" data-url="register.php" data-is-modal="true">Εγγραφή</button></div>
          <div class="text-secondary" style="margin:10px;"> ή </div>
          <div><button class="btn btn-outline btn-primary" data-provide="modaler" data-url="login.php" data-is-modal="true">Είσοδος</button></div>


         <?php } ?>



      </div>
    </header>
  </section>
  <!-- END Topbar -->
  <main>



    <section class="panel panel2" style="min-height: 100vh;" data-section-name="account">
      <div class="header bb-1 border-secondary pt-50">
        <div class="header-info mt-3 mb-3 pb-0 pt-0">
          <h1 class="header-title mt-0 mb-0 pb-0 pt-0">
            <strong>Είσοδος</strong>
            <hr class="w-160px border-primary mt-3 mb-1 pb-0 pt-0">
          </h1>
        </div>
      </div><!--/.header -->

      <div class="main-content center-h m-0 pt-0 pb-0">
        <div class="px-15 py-10" style="background: white;">
        <?php
                if(!($user->isLoggedIn())) {
                  $showForm = 1;
                } else {
                  $showForm = 0;
                }
                 if(Input::exists())
                 {
                   if(Token::check(Input::get('token')))
                  {
                    $validate 	= new Validation();
                    $validation = $validate->check($_POST, array(
                      'username'	=> array(
                        'required'	=> true
                        ),
                      'password'	=> array(
                        'required'	=> true
                        )
                    ));

                    if($validation->passed())
                    {
                      $user 	= new User();
                      $remember=(Input::get('remember')=== 'on') ? true : false;
                      $login 		= $user->login(Input::get('username'), Input::get('password'),$remember);

                      if($login)
                      {
                        $showForm = 0;
                        Redirect::to('index.php');

                      }
                      else {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <strong>Ωχ!</strong> κάτι πήγε στραβά...
                </div>';
                      }

                    } else {
                      ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <strong>Λάθος είσοδος:</strong><br />
                      <?php
                      foreach ($validation->errors() as $error) {

                        echo $error, '<br />';
                      } ?>
                      </div>
                      <?php
                    }
                  }
                }
                if ($showForm) {

          ?>
        <form class="form-type-material text-center" action="loginresult.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="username" id="username" autocomplete="off">
            <label for="username">Username</label>
          </div>

          <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" autocomplete="off">
            <label for="password">Password</label>
          </div>

          <div class="form-group flexbox">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="remember" id="remember">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Να με θυμάσαι.</span>
            </label>
            <a class="text-muted hover-primary fs-13" href="#">Ξεχάσατε τον κωδικό σας;</a>
          </div>

          <div class="form-group">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <button class="btn btn-w-xl btn-primary" type="submit" value="submit">Είσοδος</button>
          </div>
        </form>
        <hr class="w-30px">
        <p class="text-center text-muted fs-13 mt-10">Δεν έχετε λογαριασμό; <a class="text-primary fw-500" href="#">Δημιουργία νέου λογαρισμού</a></p>
      <?php } ?>
      </div>
    </div>
</section>

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
