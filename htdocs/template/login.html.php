<?php ob_start(); ?>
<div class="container">
<?php
if (isset($_POST['login'])) {
    $username = strip_tags(trim($_POST['username']));
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberme']) ? true : false;

    if (empty($username) || empty($password)) {
        echo "<div class='alert alert-danger' role='alert'>Niste izpolnili vseh polj!</div>";
    } else {
        require_once 'php/db.php';

        $sql = "SELECT password, userUUID, username, admin FROM users WHERE username = '$username'";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hPassword = $row['password'];
            $userUUID = $row['userUUID'];
            $username = $row['username'];

            if (password_verify($password, $hPassword)) {
                $_SESSION['userUUID'] = $userUUID;
                $_SESSION['username'] = $username;
                $datetime = date('Y-m-d H:i:s');

                if ($rememberMe) {
                    $rawToken = bin2hex(random_bytes(32));
                    $hashedToken = hash('sha256', $rawToken);

                    $sqlCheck = "SELECT * FROM sessions WHERE userUUID = '$userUUID'";
                    $resultCheck = mysqli_query($link, $sqlCheck);

                    if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
                        $sqlUpdate = "UPDATE sessions SET token = '$hashedToken' WHERE userUUID = '$userUUID'";
                        mysqli_query($link, $sqlUpdate);
                    } else {
                        $sqlInsert = "INSERT INTO sessions (userUUID, token, created, lastLogin) VALUES ('$userUUID', '$hashedToken', '$datetime', '$datetime')";
                        mysqli_query($link, $sqlInsert);
                    }

                    $expiry = time() + 86400;
                    setcookie("rememberme", $rawToken, $expiry, "/", "", false, true);
                } else {
                    $sqlUpdate = "UPDATE sessions SET lastLogin = '$datetime' WHERE userUUID = '$userUUID'";
                    mysqli_query($link, $sqlUpdate);
                }

                if ($row['admin'] == 1) {
                    $_SESSION['admin'] = 1;
                }

                echo "<div class='alert alert-success' role='alert'>Prijava uspešna!</div>";

                header("Location: https://localhost/profile");
            } else {
                $sqlAttempts = "SELECT attempts FROM sessions WHERE userUUID = '$userUUID'";
                $result = mysqli_query($link, $sqlAttempts);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $attempts = $row['attempts'] + 1;

                    $updateSql = "UPDATE sessions SET attempts = $attempts WHERE userUUID = '$userUUID'";
                    mysqli_query($link, $updateSql);

                    if ($attempts > 2) {
                        $lockSql = "UPDATE users SET locked = 1 WHERE userUUID = '$userUUID'";
                        mysqli_query($link, $lockSql);

                        echo "<div class='alert alert-danger' role='alert'>Vaš račun je zaklenjen. </div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Napačno geslo.</div>";
                    }
                }
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Uporabniško ime ne obstaja!</div>";
        }
        mysqli_close($link);
    }
}
?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="mb-4 text-center">Prijavi se</h4>
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Uporabniško ime</label>
                    <input name="username" type="text" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Geslo</label>
                    <input name="password" type="password" class="form-control" id="password" required>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label" for="rememberme">Zapomni si me</label>
                    <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme">
                </div>
                <button name="login" type="submit" class="btn btn-primary w-100">Prijavi se</button>
                <div>
                    <a href="/forgotpassword" class="btn btn-link p-0 text-decoration-none">Pozabljeno geslo</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>