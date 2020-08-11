<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hooks_PreCheck{
  var $RESULT;
  function pre_Security_checks(){
    // Step 2: Add Default Header Option
    header("content-type:application/json");
    // Step 1: Validate POST Request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->RESULT["status"] = "Failed";
      $this->RESULT["message"] = "Request not allowed!";
      exit(json_encode($this->RESULT));
    }
  }
}
?>
