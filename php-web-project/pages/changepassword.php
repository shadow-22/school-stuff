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
            <a class="nav-link active" href="index.php?page=changepassword">αλλαγη κωδικού</a>
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
                  <h6 class="text-uppercase ls-2">αλλαγη του κωδικου μου:</h6>
                </div>

                <div class="gap-items-2">
                  <?php
                  if(Input::exists())
                  {
                  	if(Token::check(Input::get('token'))){
                      $validate = new Validation();
                      $validation = $validate->check($_POST, array(
                        'password_current'	=> array(
                          'required'	=> true,
                          'min'		=> 6
                          ),
                        'password_new'		=> array(
                          'required'	=> true,
                          'min'		=> 6
                          ),
                        'password_new_again'	=> array(
                          'required'	=> true,
                          'min'		=> 6,
                          'matches'	=> 'password_new'
                          ),
                      ));

                      if($validation->passed()){
                        if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
                  				echo "Wrong Current Password";


                        } else {
                          $salt = Hash::salt(32);
                          $user->update(array(
                            'password'	=> Hash::make(Input::get('password_new'), $salt),
                            'salt'		=> $salt
                            ));

                          echo '<div class="alert alert-success alert-dismissible fade show" role="success">
                    <button type="button" class="close" data-dismiss="success" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                    <strong>Έγινε!</strong><br />
                    <a class="no-underline" href="logout.php">Έξοδος Χρήστη;</a>
                  </div>';

                        }

                        } else {
                          ?>
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <strong>Λάθος:</strong><br />
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
                  <form action="" method="post">
                    <div class="form-group col-12">
                      <label for="password">Current password</label>
                      <input class="form-control" type="password" name="password_current" id="password_current" data-minlength="8" data-provide="pwstrength"  autocomplete="off">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">
                      <label for="password">New password</label>
                      <input class="form-control" type="password" name="password_new" id="password_new" data-minlength="8" data-provide="pwstrength"  autocomplete="off">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">
                      <label for="password">New password again</label>
                      <input class="form-control" type="password" name="password_new_again" id="password_new_again" data-minlength="8" data-provide="pwstrength"  autocomplete="off">
                      <div class="invalid-feedback"></div>
                    </div>
                    <br />
                    <center><input type="submit" class="btn btn-primary" value="Επιβεβαίωση Αλλαγής"></center>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                  </form>
                </div>
              </div>
            </div>


          </div>


        </div>
    </section>
