<main>
  <section class="panel panel1" style="min-height: 100vh;" data-section-name="account">

      <div class="main-content" style="margin-top: 50px;">
        <div class="row center-h">

          <div class="col-md-8">

            <div class="card">
              <div class="card-body">
                <div class="flexbox align-items-baseline mb-20">
                  <h6 class="text-uppercase ls-2">Δημιουργία Εκδήλωσης Παρόχου:</h6>
                </div>

                <div class="gap-items-2">
                  <?php
                  if(Input::exists())
                  {
                  	if(Token::check(Input::get('token'))){
                      $validate = new Validation();
                      $validation = $validate->check($_POST, array(
                        'eventname'=>array(
                          'required'=>true
                        ),

                        'price' => array(
                          'required' => true,
                          'min' => 0
                        ),

                        'age_low' => array(
                          'required' => true,
                          'min' => 0
                        ),
                        'age_high' => array(
                          'required' => true
                        ),
                        'ticket_stock' => array(
                          'required' => true
                        ),
                        'type' => array(
                          'required' => true
                        ),
                        'description' => array(
                          'required' => true
                        ),
                        'start_date' => array(
                          'required' => true
                        ),
                        'end_date' => array(
                          'required' => true
                        ),
                        'place' => array(
                          'required' => true
                        )
                      ));

                      if($validation->passed()){
                        $place = Input::get('place');
                        $geocode=file_get_contents("https://maps.google.com/maps/api/geocode/json?address=".urlencode($place)."&key=AIzaSyCXYsdjQbCq1bjrn6ohMnqChThX0-8ijMY");

                        $output= json_decode($geocode);

                        $lat = $output->results[0]->geometry->location->lat;
                        $lng = $output->results[0]->geometry->location->lng;

                        $user->create2(array(

                         'provider_id' => $user->data()->id,
                         'eventname'  => Input::get('eventname'),
                         'pr_name'  => $user->data()->firstname,
                         'pr_surname'  => $user->data()->secondname,
                         'price'  => Input::get('price'),
                         'start_time' => Input::get('start_time'),
                         'end_time' => Input::get('end_time'),
                         'age_low' => Input::get('age_low'),
                         'age_high' =>  Input::get('age_high'),
                         'ticket_stock' => Input::get('ticket_stock'),
                         'type' => Input::get('type'),
                         'description' =>  Input::get('description'),
                         'long_description' =>  Input::get('long_description'),
                         'start_date' => Input::get('start_date'),
                         'end_date' => Input::get('end_date'),
                         'place' => Input::get('place'),
                         // 'latlng' => "GeomFromText('Point(0, 0)')",
                         'lat' => $lat,
                         'lng' => $lng,
                       ),'activity');

                       echo '<div class="alert alert-success alert-dismissible fade show" role="success">
                 <button type="button" class="close" data-dismiss="success" aria-label="Close">
                   <span aria-hidden="true">×</span>
                 </button>
                 <strong>Έγινε!</strong><br />
                 <a class="no-underline" href="index.php">Επιστροφή στην αρχική;</a>
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
                  ?>
                  <form action="" method="post">
                    <div class="form-group col-12">
                      <label for="eventname">Όνομα Εκδήλωσης*</label>
                      <input class="form-control" type="text" name="eventname" value="<?php echo escape(Input::get('eventname')); ?>" autocomplete="off">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-6">
                      <label>Tιμή*</label>
                      <input class="form-control" type="text" name="price" value="<?php echo escape(Input::get('price')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Ημερομηνία Έναρξης*</label>
                      <input class="form-control" type="date" name="start_date" value="<?php echo escape(Input::get('start_date')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Ημερομηνία Λήξης*</label>
                      <input class="form-control" type="date" name="end_date" value="<?php echo escape(Input::get('end_date')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Ώρα Έναρξης*</label>
                      <input class="form-control" type="time" name="start_time" value="<?php echo escape(Input::get('start_time')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                      <label>Ώρα λήξης*</label>
                      <input class="form-control" type="time" name="end_time" value="<?php echo escape(Input::get('end_time')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label>Κατώτατη Ηλικία συμμετοχόντων*</label>
                      <input class="form-control" type="text" name="age_low" value="<?php echo escape(Input::get('age_low')); ?>" required>
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">
                      <label>Ανώτατη Ηλικία συμμετοχόντων*</label>
                      <input class="form-control" type="text" name="age_high" value="<?php echo escape(Input::get('age_high')); ?>" required>
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">

                      <label for="ticket_stock" class="col-form-label">Απόθεμα εισητηρίων*</label>
                      <input type="text" class="form-control" name="ticket_stock" value="<?php echo escape(Input::get('ticket_stock')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label>Tύπος Δραστηριότητας:*</label>
                      <input class="form-control" type="text" name="type" value="<?php echo escape(Input::get('type')); ?>" required>
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-12">
                      <label for="description" class="col-form-label">Περιγραφή για την εκδήλωση*:</label>
                      <input type="text" class="form-control" name="description" value="<?php echo escape(Input::get('description')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label for="description" class="col-form-label">Παραπάνω λεπτομέρειες:</label>
                      <input type="text" class="form-control" name="long_description" value="<?php echo escape(Input::get('long_description')); ?>" autocomplete="off">
                    </div>

                    <div class="form-group col-12">
                      <label>Διεύθυνση Χώρου*</label>
                      <input class="form-control" type="text" name="place" id="place" value="<?php echo escape(Input::get('place')); ?>" autocomplete="off">
                    </div>

                    <br />
                    <center><input type="submit" class="btn btn-primary" value="Επιβεβαίωση"></center>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                  </form>
                </div>
              </div>
            </div>


          </div>


        </div>
    </section>
