<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

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

  				Session::flash('home', 'Details Updated');
  				Redirect::to('index.php');
  			} catch(Exception $e){
  				die($e->getMessage());
  			}


      } else {
          foreach ($validation->errors() as $error) {
            echo $error, '<br>';
          }
      }
  }
}
?>

<form action="" method="post">
	<div class="field">
		<label for="firstname">Όνομα:</label>
		<input type="text" name="firstname" id="firstname" value="<?php echo escape($user->data()->firstname); ?>">
  </div>

  <div class="form-group col-6">
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

  <div class="form-group">
    <label for="home1" class="col-form-label">Διεύθυνση 1</label>
    <input type="text" class="form-control" name="home1" id="home1" value="<?php echo escape($user->data()->home1); ?>" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="home2" class="col-form-label">Διεύθυνση 2</label>
    <input type="text" class="form-control" name="home2" id="home2" value="<?php echo escape($user->data()->home2); ?>" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="city" class="col-form-label">Πόλη</label>
    <input type="text" class="form-control" name="city" id="city" value="<?php echo escape($user->data()->city); ?>" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="state" class="col-form-label">Νομός</label>
    <input type="text" class="form-control" name="state" id="state" value="<?php echo escape($user->data()->state); ?>" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="zip" class="col-form-label">Ταχ. Κώδικας</label>
    <input type="text" class="form-control" name="zip" id="zip" value="<?php echo escape($user->data()->zip); ?>" autocomplete="off">
  </div>

  <div class="form-group col-12">
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

  <div class="form-group col-12">
    <label>Όνομα στην κάρτα/Όνομα Δικαιούχου</label>
    <input class="form-control" type="text" name="cardname" id="cardname" value="<?php echo escape($user->data()->cardname); ?>" autocomplete="off">
  </div>



  	<input type="submit" value="Update">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">


  <ul>

      <li><a href="changepassword.php">Change Password</a></li>
  </ul>
</form>
