<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['send-otp'] = 'SignIn/api_sendOtp';
$route['verify-otp'] = 'SignIn/api_verifyOtp';
$route['get-book-details'] = 'api/api_get_book_details';
$route['get-all-books-details'] = 'api/api_get_books';
$route['get-categories'] = 'api/api_getcategories';
$route['get-user-details'] = 'api/api_get_user_details';
$route['update-profile'] = 'api/api_profile_update';
$route['like-book'] = 'api/api_like_book';
$route['dislike-book'] = 'api/api_dislike_book';
$route['add-bookmark-book'] = 'api/api_add_bookmark_book';
$route['get-bookmark-book'] = 'api/api_get_bookmark_book';
$route['add-comment-book'] = 'api/api_add_comment_book';
$route['fetch-user-transaction'] = 'api/api_fetch_user_transaction';
$route['get-comment-book'] = 'api/api_get_comment_book';
