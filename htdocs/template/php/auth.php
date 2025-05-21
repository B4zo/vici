<?php
// Cookie checker
if (!isset($_SESSION['userUUID']) && isset($_COOKIE['rememberme'])) {
  $token = $_COOKIE['rememberme'];
  $tokenHashed = hash('sha256', $token); 

  require_once 'db.php';

  $sqlCookie = "SELECT sessions.userUUID, users.username, users.admin FROM sessions JOIN users ON sessions.userUUID = users.userUUID WHERE sessions.token = '$tokenHashed'";
  $resultCookie = mysqli_query($link, $sqlCookie);

  if ($resultCookie && mysqli_num_rows($resultCookie) === 1) {
      $row = mysqli_fetch_assoc($resultCookie);
      $_SESSION['userUUID'] = $row['userUUID'];
      $_SESSION['username'] = $row['username'];
      if($row['admin'] == 1) {
        $_SESSION['admin'] = 1;
      }
  } else {
      setcookie("rememberme", "", time() - 3600, "/", "", false, true);
  }

  mysqli_close($link);
}
?>