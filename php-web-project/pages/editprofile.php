<?php
  // Login Check
  if((!$user->isLoggedIn())) {
    Redirect::to('index.php');
  }

 ?>
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
            <a class="nav-link active" href="index.php?page=editprofile">επεξεργασια</a>
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
        <div class="row center-h">

          <div class="col-md-8">

            <div class="card">
              <div class="card-body">
                <div class="flexbox align-items-baseline mb-20">
                  <h6 class="text-uppercase ls-2">Επεξεργασια του προφίλ μου:</h6>
                </div>

                <div class="gap-items-2">
                  <?php
                  if(Input::exists())
                  {
                  	if(Token::check(Input::get('token'))){
                      $validate = new Validation();
                      $validation = $validate->check($_POST, array(
                        'firstname'	=> array(
                          'min'		=> 2,
                          'max'		=> 50
                        ),
                        'secondname' => array(
                          'min'=>2,
                          'max'=>50
                        ),
                        'username'=>array(
                            'min'=>2,
                            'max'=>20,
                        ),
                        'email' => array(
                          'min'=>4
                        ),
                        'home1' => array(
                          'min'=>2,
                          'max'=>50
                        ),
                        'home2' => array(
                          'min'=>2,
                          'max'=>50
                        ),
                        'city' => array(
                          'min'=>2,
                          'max'=>50
                        ),
                        'state' => array(
                          'min'=>2,
                          'max'=>50
                        ),
                        'cardnumber' => array(
                          'min'=>12,
                          'max'=>12
                        ),
                        'expiry' => array(
                        ),
                        'cvc' => array(
                          'min'=>4
                        ),
                        'cardname' => array(
                          'min'=>3,
                          'max'=>12
                        )
                        ));


                        if($validation->passed()) {

                          try{
                    				$user->update(array(
                    					'firstname'	=> Input::get('firstname'),
                              'secondname'	=> Input::get('secondname'),
                              'username'	=> Input::get('username'),
                              'email' => Input::get('email'),
                              'home1' =>  Input::get('home1'),
                              'home2' =>  Input::get('home2'),
                              'city' => Input::get('city'),
                              'state' =>  Input::get('state'),
                              'zip' =>  Input::get('zip'),
                              'cardnumber' => Input::get('cardnumber'),
                              'expiry' => date('Y-m'),
                              'cvc' =>Input::get('cvc'),
                              'cardname' =>Input::get('cardname')
                    				));
                            echo '<div class="alert alert-success alert-dismissible fade show" role="success">
                      <button type="button" class="close" data-dismiss="success" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <strong>Έγινε!</strong>
                    </div>';
                    			} catch(Exception $e){
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
                  ?>
                  <form action="index.php?page=editprofile" method="post">
                  	<div class="form-group col-12">
                  		<label>Όνομα:</label>
                  		<input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo escape($user->data()->firstname); ?>">
                    </div>

                    <div class="form-group col-12">
                      <label>Επώνυμο</label>
                      <input class="form-control" type="text" name="secondname" id="secondname" value="<?php echo escape($user->data()->secondname); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label for="username">Username</label>
                      <input class="form-control" type="text" data-minlength="6" name="username" id="username" value="<?php echo escape($user->data()->username); ?>" autocomplete="off"required>
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">
                      <label>Email</label>
                      <input class="form-control" type="text" name="email" id="email" value="<?php echo escape($user->data()->email); ?>" required>
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">
                      <label for="home1" class="col-form-label">Διεύθυνση 1</label>
                      <input type="text" class="form-control" name="home1" id="home1" value="<?php echo escape($user->data()->home1); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label for="home2" class="col-form-label">Διεύθυνση 2</label>
                      <input type="text" class="form-control" name="home2" id="home2" value="<?php echo escape($user->data()->home2); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label for="city" class="col-form-label">Πόλη</label>
                      <input type="text" class="form-control" name="city" id="city" value="<?php echo escape($user->data()->city); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label for="state" class="col-form-label">Νομός</label>
                      <input type="text" class="form-control" name="state" id="state" value="<?php echo escape($user->data()->state); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label for="zip" class="col-form-label">Ταχ. Κώδικας</label>
                      <input type="text" class="form-control" name="zip" id="zip" value="<?php echo escape($user->data()->zip); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Αριθμός Κάρτας/Αριθμός ΙΒΑΝ</label>
                      <input class="form-control" type="text" name="cardnumber" id="cardnumber" value="<?php echo escape($user->data()->cardnumber); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Expiry date</label>
                      <input class="form-control" type="text" name="expiry" id="expiry" value="<?php echo escape($user->data()->expiry); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>CVC//Τράπεζα</label>
                      <input class="form-control" type="text" name="cvc" id="cvc" value="<?php echo escape($user->data()->cvc); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Όνομα στην κάρτα/Όνομα Δικαιούχου</label>
                      <input class="form-control" type="text" name="cardname" id="cardname" value="<?php echo escape($user->data()->cardname); ?>" autocomplete="off">
                    </div>




                  		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                      <br />
                      <center><input type="submit" class="btn btn-primary" value="Ενημέρωση"></center>
                  </form>
                </div>
              </div>
            </div>


          </div>


        </div>
    </section>
