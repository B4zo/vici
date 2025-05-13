<?php
session_start();
require_once 'template/php/auth.php';
// Front controller
$page = $_GET['page'] ?? '';
switch ($page) {
  case '':
    include 'template/index.html.php';
    break;
  case 'recents':
    include 'template/recents.html.php';
    break;
  case 'signup':
    include 'template/signup.html.php';
    break;
	case 'login':
		include 'template/login.html.php';
    break;
  case 'logout':
    include 'template/logout.html.php';
    break;
  case 'profile':
    include 'template/profile.html.php';
    break;
  case 'studio':
    include 'template/studio.html.php';
    break;
  case 'forbidden':
    include 'template/forbidden.html.php';
    break;
  case 'newpost':
    include 'template/php/newpost.php';
    break;
  case 'verify':
    include 'template/verify.html.php';
    break;
  case 'changepassword':
    include 'template/changepassword.html.php';
    break;
  case 'forgotpassword':
    include 'template/forgotpassword.html.php';
    break;
  default:
		include 'template/error.html.php';
    break;
}
?>