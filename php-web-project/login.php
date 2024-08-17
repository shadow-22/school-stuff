
<?php
require_once 'core/init.php';
if(Session::exists('home'))
 {
   echo '<p>' .Session::flash('home').'</p>';
 }


   $user = new User();

   if($user->isLoggedIn()) {
   ?>
   <li class="menu-item active">
     <a class="menu-link no-underline" href="#">
       <span class="title">Hello,<?php echo escape($user->data()->username); ?></span>
     </a>
   </li>

   <?php
     } else {
       echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register</a>';
     }
  ?>
  <!-- Modal -->
<div class="modal modal-center fade">
  <div class="modal-dialog w-400px" style="max-width:90vw;">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="px-15 py-10">

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
                				else{
                					echo "sorry! Failed";
                				}

                      }else{
                				foreach ($validation->errors() as $error) {

                					echo $error, '<br />';
                				}
                			}
                		}
                	}
                  if ($showForm) {

            ?>

          <h4 class="header-title text-center"><strong>Είσοδος:</strong></h4>
          <hr class="border-primary w-200px"><br />

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
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" checked>
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
          <p class="text-center text-muted fs-13 mt-10">Δεν έχετε λογαριασμό; <a class="text-primary fw-500" data-dismiss="modal" data-provide="modaler" data-url="register.php" data-is-modal="true">Δημιουργία νέου λογαρισμού</a></p>
        <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
