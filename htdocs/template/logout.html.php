<?php
    session_destroy();
    setcookie("rememberme", "", time() - 3600, "/", "", false, true);
    header("location: ../");
?>