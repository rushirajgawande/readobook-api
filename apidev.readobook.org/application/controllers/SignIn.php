<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SignIn extends CI_Controller
{
  var $RESULT;
  public function __construct()
  {
    parent::__construct();
    $this->RESULT["status"]  = "0";
    $this->RESULT["message"] = "Script Run Unsuccesfull check params";
  }
  // function api_forgotpassword()
  // {
  //     if ($this->input->post('email', TRUE)) {
  //         $results_user = $this->db->get_where('users', array(
  //             'email' => $_POST['email']
  //         ));
  //         if ($results_user->num_rows() > 0) {
  //             if ($_POST['email'] == $results_user->row()->email) {
  //                 $this->RESULT["status"]  = "1";
  //                 $this->RESULT["message"] = "Password updated Successfully";
  //             } else {
  //                 $this->RESULT["message"] = "Incorrect current password!";
  //             }
  //         } else {
  //             $this->RESULT["message"] = "User does not exist!";
  //         }
  //     } else {
  //         $this->RESULT["message"] = "Missing params!";
  //     }
  //     return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  // }
  function api_sendOtp(){
    $randOtp = rand(1000, 9999);
    if (
      $this->input->post('mobile', TRUE)
      && strlen($this->input->post('mobile')) == 10
      && $this->db->delete(
        'otp',
        array(
          'mobile' => $_POST['mobile']
        )
        )
        && $this->db->insert(
          'otp',
          array(
            'otp' => $randOtp,
            'mobile' => $_POST['mobile'],
            'type' => 'SIGNIN',
            'from_ip' => $this->input->ip_address()
          )
          )
        ) {
          // Prepare Message : Sent Booking Confirmation Msg
          $api_key = '25C3DC47484725';
          $contacts = $_POST['mobile'];
          $from = 'BILSAM';
          $sms_text = urlencode('Your one time password for mobile verification is ' . $randOtp . '. Do not share your OTP.');
          //Submit to server
          $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
          $response = curl_exec($ch);
          curl_close($ch);
          $this->RESULT["status"]  = "1";
          $this->RESULT["message"] = "OTP Has been sent Successfully!";
        }
        return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
      }
      function api_verifyOtp(){
        if (
          $this->input->post('otp', TRUE)
          && strlen($this->input->post('otp')) == 4
          && $this->input->post('mobile', TRUE)
          && strlen($this->input->post('mobile')) == 10
          && $this->db->get_where(
            'otp',
            array(
              'mobile' => $_POST['mobile'],
              'otp' => $_POST['otp']
            )
            )->num_rows() > 0
          ) {
            $results_user_check = $this->db->get_where(
              'users',
              array(
                'mobile' => $_POST['mobile']
              )
            );
            if (
              $results_user_check->num_rows() > 0
            ) {
              $this->RESULT["status"]  = "1";
              $this->RESULT["message"] = "OTP Has been verified Successfully & user details found!";
              $this->RESULT["data"] = $results_user_check->row();
              $this->RESULT["authToken"] = $this->Model_securityTokens->createAuthToken($results_user_check->row()->userid);
            } elseif (
              $this->db->insert(
                'users',
                array(
                  'mobile' => $_POST['mobile'],
                  'refid' => $_POST['mobile'],
                  'refname' => $_POST['mobile']
                )
                )
              ) {
                $this->RESULT["status"]  = "1";
                $this->RESULT["message"] = "OTP Has been verified Successfully & new user created!";
                $results_get_user_details = $this->db->get_where('users', array( 'mobile' => $_POST['mobile'] ));
                $this->RESULT["data"] = $results_get_user_details->row();
                $this->RESULT["authToken"] = $this->Model_securityTokens->createAuthToken($results_get_user_details->row()->userid);
              } else {
                $this->RESULT["message"] = "Error occurred, try again later!";
              }
            } else {
              $this->RESULT["message"] = "Incorrect OTP!";
            }
            return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
          }
        }
