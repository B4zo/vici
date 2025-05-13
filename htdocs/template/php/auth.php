<?php
// Cookie checker
if (!isset($_SESSION['userUUID']) && isset($_COOKIE['rememberme'])) {
  $token = $_COOKIE['rememberme'];
  $tokenHashed = hash('sha256', $token); 

  require_once 'db.php';

  $sqlCookie = "SELECT userUUID, admin FROM sessions WHERE token = '$tokenHashed'";
  $resultCookie = mysqli_query($link, $sqlCookie);

  if ($resultCookie && mysqli_num_rows($resultCookie) === 1) {
      $row = mysqli_fetch_assoc($resultCookie);
      $_SESSION['userUUID'] = $row['userUUID'];
      if($row['admin'] == 1) {
        $_SESSION['admin'] = 1;
      }
  } else {
      setcookie("rememberme", "", time() - 3600, "/", "", false, true);
  }

  mysqli_close($link);
}
?>