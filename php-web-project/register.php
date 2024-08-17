<!-- Modal -->
<div class="modal modal-center fade">
  <div class="modal-dialog" style="width: 500px; max-width:90vw;">
    <div class="modal-content">
      <div class="modal-body" style="max-height:95vh; overflow-y: auto;">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="px-15 py-10">
          <h4 class="header-title text-center"><strong>Δημιουργία λογαρισμού χρήστη:</strong></h4>
          <hr class="border-primary w-200px"><br />
          <!--
          |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
          | Form validation
          |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
          !-->
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
                 foreach ($validate->errors() as $error) {
           				echo $error, '<br />';
               }
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
    </div>
  </div>
</div>
