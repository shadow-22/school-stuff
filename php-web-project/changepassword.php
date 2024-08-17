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

          Session::flash('home', 'Password Changed');
          Redirect::to('index.php');

        }

      }else {
  			foreach ($validation->errors() as $error) {
  				echo $error, '<br>';
  			}
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

   <input type="submit" value="Change">
   <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
 </form>
