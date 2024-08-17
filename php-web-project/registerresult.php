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
            <strong>Εγγραφή</strong>
            <hr class="w-160px border-primary mt-3 mb-1 pb-0 pt-0">
          </h1>
        </div>
      </div><!--/.header -->

      <div class="main-content center-h m-0 pt-0 pb-0">
        <div class="px-15 py-10" style="width:60vw; background: white;">
          <?php

          /*array has all the rules for our validation*/
          require_once 'core/init.php';

            if(Input::exists()){
              if(Token::check(Input::get('token')) ) {
                $validate = new Validation();
                $validation=$validate->check($_POST,array(
                  'username'=>array(
                      'required'=>true,
                      'min'=>2,
                      'max'=>20,
                      'unique'=>'users'
                  ),

                  'e-mail' => array(
                    'required' => true,
                    'min'=>4,
                    'unique'=>'users'
                  ),

                  'password'=>array(
                    'required'=>true,
                    'min'=>6
                  ),

                  'password_again' => array(
            				'required' => true,
            				'matches' => 'password'
            			),
                  'firstname' => array(
            				'required' => true,
            				'min'=>2,
                    'max'=>50
            			),
                  'secondname' => array(
            				'required' => true,
            				'min'=>2,
                    'max'=>50
            			),
                  'home1' => array(
            				'required' => true,
            				'min'=>2,
                    'max'=>50
            			),
                  'city' => array(
                    'required' => true,
                    'min'=>2,
                    'max'=>50
                  ),
                  'state' => array(
                    'required' => true,
                    'min'=>2,
                    'max'=>50
                  ),
                  'cardnumber' => array(
                    'required' => true,
                    'min'=>12,
                    'max'=>12
                  ),
                  'expiry' => array(
                    'required' => true,
                  ),
                  'cvc' => array(
                    'required' => true,
                    'min'=>4,
                    'max'=>4
                  ),
                  'cardname' => array(
                    'required' => true,
                    'min'=>3,
                    'max'=>12
                  ),
                  'test'=>array(
                    'required'=>true
                  )
              ));

               if($validation->passed()){
                    //echo 'Success registration';
                  $user=new User();
                  $salt=Hash::salt(32);

                    try{
              				$user->create(array(
              					'username'	=> Input::get('username'),
              					'password'	=> Hash::make(Input::get('password'), $salt),
              					'salt'		=> $salt,
              					'firstname'	=> Input::get('firstname'),
                        'secondname'	=> Input::get('secondname'),
              					'joined'	=> date('Y-m-d H:i:s'),
              					'group'	=> 1,
                        'e-mail' => Input::get('e-mail'),
                        'home1' =>  Input::get('home1'),
                        'city' => Input::get('city'),
                        'state' =>  Input::get('state'),
                        'zip' =>  Input::get('zip'),
                        'cardnumber' => Input::get('cardnumber'),
                        'expiry' => date('Y-m'),
                        'cvc' =>Input::get('cvc'),
                        'cardname' =>Input::get('cardname')
              					));

                        Session::flash('success','You registered successfully');
                        Redirect::to('index.php');
                      } catch(Exception $e) {
                          die($e->getMessage);
                      }
                    } else {
                      ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <strong>Λάθος είσοδος:</strong><br />
                      <?php
                      foreach ($validate->errors() as $error) {

                        echo $error, '<br />';
                      } ?>
                      </div>
                      <?php
                    }
                  }
                }
          ?>
          <form data-provide="wizard" novalidate="true" method="post" action="registerresult.php">
            <ul class="nav nav-process nav-process-circle">
                <li class="nav-item">
                  <span class="nav-title">Στοιχεία</span>
                  <a class="nav-link" data-toggle="tab" href="#wizard-validate-1"></a>
                </li>

                <li class="nav-item">
                  <span class="nav-title">Διεύθυνση</span>
                  <a class="nav-link" data-toggle="tab" href="#wizard-validate-2"></a>
                </li>

                <li class="nav-item">
                  <span class="nav-title">Πορτοφόλι</span>
                  <a class="nav-link" data-toggle="tab" href="#wizard-validate-3"></a>
                </li>
              </ul>


            <div class="tab-content">
              <div class="tab-pane fade active show" id="wizard-validate-1" >
                <p class="text-center text-muted">
                  <i class="fa fa-quote-left fa-2x fa-pull-left"></i>
                  <i>Δώστε μας μερικά στοιχεία.</i>
                </p>
                <hr class="w-200px">
                <div class="row">
                  <div class="form-group col-6">
                    <label>Όνομα</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo escape(Input::get('firstname')); ?>" autocomplete="off">
                  </div>

                  <div class="form-group col-6">
                    <label>Επώνυμο</label>
                    <input class="form-control" type="text" name="secondname" id="secondname" value="<?php echo escape(Input::get('secondname')); ?>" autocomplete="off">
                  </div>

                  <div class="form-group col-12">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" data-minlength="6" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"required>
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group col-12">
                    <label>Email</label>
                    <input class="form-control" type="text" name="e-mail" id="e-mail" value="<?php echo escape(Input::get('e-mail')); ?>" required>
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group col-12">
                    <label for="password">Κωδικός</label>
                    <input class="form-control" type="password" name="password" id="password" data-minlength="8" data-provide="pwstrength" placeholder="Enter password" autocomplete="off">
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group col-12">
                    <label>Επιβεβαίωση κωδικού</label>
                    <input class="form-control" type="password" name="password_again" id="password_again" data-minlength="8" data-match="#input-pass" placeholder="Re-Enter password" autocomplete="off">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>



              <div class="tab-pane fade" id="wizard-validate-2" data-provide="validation">
                <p class="text-center text-muted">
                  <i>Κείμενο...</i>
                </p>
                <hr class="w-200px">
                <div class="form-group">
                  <label for="inputAddress" class="col-form-label">Διεύθυνση γραμμή 1</label>
                  <input type="text" class="form-control" name="home1" id="home1" value="<?php echo escape(Input::get('home1')); ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="inputAddress2" class="col-form-label">Διεύθυνση γραμμή 2</label>
                  <input type="text" class="form-control" id="inputAddress2">
                </div>

                <div class="form-group">
                  <label for="inputCity" class="col-form-label">Πόλη</label>
                  <input type="text" class="form-control" name="city" id="city" value="<?php echo escape(Input::get('city')); ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="inputState" class="col-form-label">Νομός</label>
                  <input type="text" class="form-control" name="state" id="state" value="<?php echo escape(Input::get('state')); ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="inputZip" class="col-form-label">Ταχ. Κώδικας</label>
                  <input type="text" class="form-control" name="zip" id="zip" value="<?php echo escape(Input::get('zip')); ?>" autocomplete="off">
                </div>
              </div>



              <div class="tab-pane fade" id="wizard-validate-3" data-provide="validation">
                <p class="text-center text-muted">
                  <i>Κείμενο...</i>
                </p>
                <hr class="w-200px">
                <div class="row">
                  <div class="form-group col-12">
                    <label>Αριθμός Κάρτας</label>
                    <input class="form-control" type="text" name="cardnumber" id="cardnumber" value="<?php echo escape(Input::get('cardnumber')); ?>" autocomplete="off">
                  </div>

                  <div class="form-group col-6">
                    <label>Expiry date</label>
                    <input class="form-control" type="text" name="expiry" id="expiry" value="<?php echo escape(Input::get('expiry')); ?>" autocomplete="off">
                  </div>

                  <div class="form-group col-6">
                    <label>CVC</label>
                    <input class="form-control" type="text" name="cvc" id="cvc" value="<?php echo escape(Input::get('cvc')); ?>" autocomplete="off">
                  </div>

                  <div class="form-group col-12">
                    <label>Όνομα στην κάρτα</label>
                    <input class="form-control" type="text" name="cardname" id="cardname" value="<?php echo escape(Input::get('cardname')); ?>" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label class="custom-control custom-checkbox mr-3">
                    <input class="custom-control-input" name="test" value="0" type="hidden">
                    <input type="checkbox" class="custom-control-input" name="test" value="NO">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Συμφωνώ με τους όρους.</span>
                  </label>
                </div>

              </div>
            </div>

            <hr>

            <div class="flexbox">
              <button class="btn btn-secondary" data-wizard="prev" type="button">Πίσω</button>
              <button class="btn btn-secondary" data-wizard="next" type="button">Επόμενο</button>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
              <button class="btn btn-primary d-none" data-wizard="finish" type="submit">Επιβεβαίωση</button>
            </div>
          </form>
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
