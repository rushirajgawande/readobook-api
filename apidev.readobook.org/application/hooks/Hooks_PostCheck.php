<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hooks_PostCheck{
  var $RESULT;
  function post_Security_checks(){
    $instance = & get_instance();
    switch ( $instance->router->fetch_class() ) {
      case 'SignIn':
      break;
      default:
      if (
        $instance->Model_securityTokens->verifyAuth( (isset($_POST['authToken']) ? $_POST['authToken'] : rand(1000,9999)) )
      ) {
        echo json_encode($instance->RESULT);
      } else {
        $instance->RESULT["message"] = "Token not authorised!";
        exit(json_encode($this->RESULT));
      }
      break;
    }
  }
}
?>
