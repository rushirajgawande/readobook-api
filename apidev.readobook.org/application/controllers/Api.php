<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller
{
  var $RESULT, $userid;
  public function __construct()
  {
    parent::__construct();
    $this->RESULT["status"]  = "0";
    if (
      isset($_POST['authToken'])
      && strlen($_POST['authToken']) > 20
      && $this->Model_securityTokens->verifyAuth($_POST['authToken'])
    ) {
      $this->userid = $this->Model_securityTokens->verifyAuth($_POST['authToken']);
    } else {
      $this->RESULT["message"] = "Request not authorised!";
      exit(
        json_encode($this->RESULT)
      );
    }
    $this->RESULT["message"] = "Script Run Unsuccesfull";
  }
  function api_get_books() {
    $results = $this->db->get('view_books_master_data');
    if($results->num_rows() > 0){
      $this->RESULT["status"]="1";
      $this->RESULT["date"]= date("d M Y");
      $this->RESULT["message"]="Script Run Succesfully!";
      $this->RESULT["books"] = $results->result();
    }
    // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  }
  function api_search_book()
  {
    if ($this->input->post("search_book", TRUE)) {
      $results = $this->db->like('title', $_POST['search_book'], 'both')->get('view_books_master_data');
      if ($results->num_rows() > 0) {
        $this->RESULT["status"]  = "1";
        $this->RESULT["date"]    = date("d M Y");
        $this->RESULT["message"] = "Script Run Succesfully!";
        $this->RESULT["books"]   = $results->result();
      }
    } else {
      $this->RESULT["message"] = "Missing params";
    }
    // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  }
  function api_getcategories()
  {
    $results = $this->db->distinct()->select('genre')->get('view_books_master_data');
    if ($results->num_rows() > 0) {
      $this->RESULT["status"]           = "1";
      $this->RESULT["date"]             = date("d M Y");
      $this->RESULT["message"]          = "Script Run Succesfully!";
      $this->RESULT["total-categories"] = $results->num_rows();
      $this->RESULT["categories"]       = $results->result();
    } else {
      $this->RESULT["message"] = "Missing params";
    }
    // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  }
  function api_get_book_details()
  {
    // if (ENVIRONMENT == 'development') {
    //   $this->RESULT["request_data"] = $_REQUEST;
    // }
    if ($this->input->post("bookid", TRUE)) {
      $results = $this->db->where('bookid', $this->input->post('bookid'))->get('view_books_master_data');
      if ($results->num_rows() > 0) {
        $cat                     = $results->row()->genre;
        $author_details          = $results->row()->authors_details;
        $this->RESULT["status"]  = "1";
        $this->RESULT["images"]  = $this->db->get_where('books_images', array(
          'bookid' => $_POST['bookid']
        ))->result();
        $this->RESULT["message"] = "Script Run Succesfull";
        $this->RESULT["books"]   = $results->row();
      }
    } else {
      $this->RESULT["message"] = "Missing params";
    }
    // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  }
  //
  // function api_send_email_on_signup_and_signup()
  // {
  //
  //   if ($this->input->post('fname', TRUE) && $this->input->post('lname', TRUE) && $this->input->post('email', TRUE) && $this->input->post('mobile', TRUE)) {
  //     $results = $this->db->get_where('users', array(
  //       'mobile' => $this->input->post('mobile')
  //     ));
  //     if ($results->num_rows() > 0) {
  //       $this->RESULT['message'] = "User already exist!";
  //     } else {
  //       if ($this->db->insert('users', array(
  //         "fname" => $_POST['fname'],
  //         "lname" => $_POST['lname'],
  //         "email" => $_POST['email'],
  //         "mobile" => $_POST['mobile']
  //       ))) {
  //         $this->RESULT["status"]  = "1";
  //         $this->RESULT["message"] = "Script Run Succesfull";
  //         $this->RESULT['message'] = "SIGN Up Sccess Message sent to Your mail!";
  //
  //       } else {
  //         $this->RESULT["status"]  = "1";
  //         $this->RESULT["message"] = "Script Run Succesfull";
  //
  //       }
  //     }
  //   }
  //   // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  // }
  //
  //
  //
  //
  // function api_login()
  // {
  //   if ($this->input->post('email', TRUE) && $this->input->post('password', TRUE)) {
  //     $results = $this->db->get_where('users', array(
  //       'email' => $_POST['email']
  //     ));
  //     if ($results->num_rows() > 0) {
  //       $password = $results->row()->password;
  //       if (password_verify($_POST['password'], $password)) {
  //         $this->session->set_userdata(array(
  //           'userid' => $results->row()->userid,
  //           'fname' => $results->row()->fname,
  //           'lname' => $results->row()->lname,
  //           'email' => $results->row()->email,
  //           'profilepic' => $results->row()->profilepic,
  //           'mobile' => $results->row()->mobile
  //         ));
  //         $this->RESULT["message"] = "Sign in success!";
  //       } else {
  //         $this->RESULT["message"] = "Incorrect credentials!";
  //       }
  //     } else {
  //       $this->RESULT["message"] = "Account does not exist please register!";
  //     }
  //   } else {
  //     $this->RESULT["message"] = "Missing params";
  //   }
  //   // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  // }
  function api_get_user_details()
  {
    if ($this->input->post('authToken', TRUE)) {
      $results = $this->db->get(
        "users",
        array(
          'userid' => $this->userid
        )
      );
      if ($results->num_rows() > 0) {
        $this->RESULT["status"]       = "1";
        $this->RESULT["message"]       = "script run Succesfull";
        $this->RESULT["date"]         = date("d M Y");
        $this->RESULT["user_details"] = $results->row();
        $results = $this->db->get('view_books_master_data');
        $this->RESULT["books"]       = $results->result();
        $this->RESULT["recommanded_books"]       = $results->result();
        $this->RESULT["top_books"]       = $results->result();
        $this->RESULT["featured_books"]       = $results->result();
      }
    }
    // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
  }
  function api_profile_update()
  {
    if (
      $this->input->post('fname')
      &&   $this->input->post('lname')
      &&   $this->input->post('email')
      &&   $this->input->post('refid')
      &&   $this->input->post('refname')
      &&   $this->input->post('gender')
      )
      {
        $this->db->update(
          'users',
          array('fname' => $this->input->post('fname'),
          'lname' => $this->input->post('lname'),
          'email' => $this->input->post('email'),
          'refid' => $this->input->post('refid'),
          'refname' => $this->input->post('refname'),
          'gender' => $this->input->post('gender')
        ),
        array('userid' => $this->userid)
      );
        $this->RESULT["status"]       = "1";
        $this->RESULT["date"]         = date("d M Y");
        $this->RESULT["message"] = "profile updated succesfully";
      }
      // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
    }
    function api_like_book()
    {
      if (
        $this->input->post('bookid',TRUE)
      ) {
        $this->db->where('bookid', $_POST['bookid'])->set('likes', 'likes + 1', FALSE)->update(
          'books'
        );
        $this->RESULT["status"]       = "1";
        $this->RESULT["message"] = "Book liked Succesfully";
      }
      // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
    }
    function api_dislike_book()
    {
      if (
        $this->input->post('bookid',TRUE)
      ) {
        $this->db->where('bookid', $_POST['bookid'])->set('dislike', 'dislike + 1', FALSE)->update(
          'books'
        );
        $this->RESULT["status"]       = "1";
        $this->RESULT["message"] = "Book disliked Successfull";
      }
      // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
    }
    function api_add_comment_book()
    {
      if (
        $this->input->post('bookid',TRUE)
        && $this->input->post('comment',TRUE)
        && (($this->input->post('rating',TRUE) >= 0) && ($this->input->post('rating',TRUE) <= 10))
      ) {
        $this->db->insert(
          'comments',
          array(
            'comment' => $this->input->post('comment'),
            'rating' => $this->input->post('rating'),
            'userid' => $this->userid,
            'bookid' =>$this->input->post('bookid'),
            'refid'=>$this->input->post('refid'),
            'refname'=>$this->input->post('refname')
          )
        );
        $this->RESULT["status"]       = "1";
        $this->RESULT["message"] = "Comment Added Succesfully";
      }else {
        $this->RESULT["message"] = "failed to add comment check params";
      }
      // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
    }
    function api_get_comment_book()
    {
      if (
        $this->input->post('bookid',TRUE)
      ) {
        $this->RESULT["status"]       = "1";
        $this->RESULT["message"]       = "Script run Succesfull";
        $this->RESULT["comments"] = $this->db->get_where(
          'comments',
          array(
            'bookid' => $this->input->post('bookid')
          )
          )->result();
        } else {
          $this->RESULT["message"] = "failed to add comment check params";
        }
        // // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
      }
      function api_add_bookmark_book()
      {
        if (
          $this->input->post('bookid',TRUE)
          )
          {
            $results = $this->db->get_where(
              "bookmarks",
              array(
                'bookid' => $this->input->post('bookid'),
                'userid'=> $this->userid
              )
            );
            if (
              $results->num_rows() > 0
            ) {
              $this->RESULT["status"]       = "1";
              $this->RESULT["message"] = "Bookmarked Already exist";
            }else {
              $this->db->insert(
                'bookmarks',
                array(
                  'userid' => $this->userid,
                  'bookid' =>$this->input->post('bookid'),
                  'refid'=>$this->input->post('refid'),
                  'refname'=>$this->input->post('refname')
                )
              );
              $this->RESULT["status"]       = "1";
              $this->RESULT["message"] = "Bookmarked Added succesfully";
            }
          }else {
            $this->RESULT["message"] = "Invalid credentials";
          }
          // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
        }
        function api_get_bookmark_book()
        {
          if (
            $this->input->post('bookid',TRUE)
          ) {
            $this->RESULT["status"]       = "1";
            $this->RESULT["message"]       = "Script run Successfull";
            $this->RESULT["bookmarks"] = $this->db->get_where(
              'bookmarks',
              array(
                'bookid' =>$this->input->post('bookid')
              )
              )->result();
            }
            // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
          }
          function api_fetch_user_transaction()
          {
            if (
              strlen($this->input->post('mobile',TRUE)) == 10
            ) {
              $this->RESULT["status"]       = "1";
              $this->RESULT["message"] = "Transaction Fetch succesfully";
              $this->RESULT["data"] = $this->db->get_where(
                'users_txn',
                array(
                  'mobile' => $this->input->post('mobile')
                )
                )->result();
              }else {
                $this->RESULT["message"] = "failed, check params";
              }
              // return $this->output->set_status_header()->set_output(json_encode($this->RESULT));
            }
          }
          ?>
