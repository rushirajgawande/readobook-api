<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Model_securityTokens extends CI_Model{
  function __construct(){
    parent::__construct();
  }

  function createAuthToken($userid){
    $authToken = password_hash(
      $userid,
      PASSWORD_DEFAULT
    );
    if (
      $this->db->delete(
        'authToken',
        array(
          'userid' => $userid
        )
      )
      && $this->db->insert(
        'authToken',
        array(
          'authToken' => $authToken,
          'userid' => $userid,
          'lat' => $this->input->post('lat'),
          'lng' => $this->input->post('lng')
        )
      )
    ) {
      return $authToken;
    }
    return rand(1000,9999);
  }


  function verifyAuth($authToken){
    $results = $this->db->get_where(
      'authToken',
      array(
        'authToken' => $authToken
      )
    );
    if (
      $results->num_rows() > 0
    ) {
      return $results->row()->userid;
    }
    return false;
  }
}
