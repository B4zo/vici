<?php ob_start();?>
<?php 
    if(isset($_SESSION['userUUID'])) {
        if (isset($_POST['change'])) {
            $currentpass = $_POST['currentpass'];
            $newpass = $_POST['newpass'];
            if (empty($currentpass) || empty($newpass)) {
                echo "<div class='alert alert-danger' role='alert'>Niste izpolnili vseh polj!</div>";
            } else {
                require_once 'php/db.php';

                $sqlPassword = "SELECT password FROM users WHERE userUUID = '" . $_SESSION['userUUID'] . "'";
                $result = mysqli_query($link, $sqlPassword);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $password = $row['password'];

                    if (password_verify($currentpass, $password)){
                        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $newpass)) {
                            echo "<div class='alert alert-danger' role='alert'>Geslo mora vsebovati črke, številke in posebne znake.</div>";
                        } else {
                            $hPassword = password_hash($newpass, PASSWORD_DEFAULT);

                            $sqlNewPass = "UPDATE users SET password = '$hPassword' WHERE userUUID = '" . $_SESSION['userUUID'] . "'";
                            mysqli_query($link, $sqlNewPass);

                            echo "<div class='alert alert-success' role='alert'>Uspešno ste spremenili geslo! Ponovno se prijavite.</div>";
                            header("Location: https://localhost/logout");
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Napačno geslo!</div>";
                    }
                } 
            }
        }
    } else {
        header("Location: https://localhost/error");
    }
?>
<div class="mx-4 my-3">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="mb-4 text-center">Spremeni geslo</h4>
            <form method="post">
                <div class="mb-3">
                    <label for="currentpass" class="form-label">Trenutno geslo</label>
                    <input name="currentpass" type="password" class="form-control" id="currentpass" required>
                </div>
                <div class="mb-3">
                    <label for="newpass" class="form-label">Novo geslo</label>
                    <input name="newpass" type="password" class="form-control" id="newpass" required>
                </div>
                <button name="change" type="submit" class="btn btn-primary w-100">Spremeni</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>