<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hook['pre_controller'][] = array(
  'class'    => 'Hooks_PreCheck',
  'function' => 'pre_Security_checks',
  'filename' => 'Hooks_PreCheck.php',
  'filepath' => 'hooks'
);
$hook['post_controller'][] = array(
  'class'    => 'Hooks_PostCheck',
  'function' => 'post_Security_checks',
  'filename' => 'Hooks_PostCheck.php',
  'filepath' => 'hooks'
);
?>
