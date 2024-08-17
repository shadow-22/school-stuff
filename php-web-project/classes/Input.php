<?php
/* check if data actually exists*/
class Input{
  public static function exists($type='post'){
    switch($type){
      case 'post':
          return(!empty($_POST)) ? true : false;
      break;
      case 'get':
          return(!empty($_GET)) ? true : false;
        break;
      default:
          return false;
      break;
    }
  }

  public static function get($item){
      /*check if item-input is available and return it*/
      if(isset($_POST[$item])){
        return $_POST[$item];
      } else if(isset($_GET[$item])){
        return $_GET[$item];
      }
      return '';

  }



}






 ?>
