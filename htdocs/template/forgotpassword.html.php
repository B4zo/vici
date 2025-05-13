<?php ob_start(); ?>
<?php
require_once 'php/db.php';

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$token = $_GET['token'] ?? null;
$showResetForm = false;

if ($token) {
    $sql = "SELECT userUUID FROM forgotpassword WHERE token = '$token' AND expires >= NOW()";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userUUID = $row['userUUID'];
        $showResetForm = true;
    } else {
        echo "<div class='alert alert-danger text-center'>Žeton je neveljaven ali je potekel.</div>";
    }
}


if (isset($_POST['reset'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];

    $sql = "SELECT userUUID FROM forgotpassword WHERE token = '$token' AND expires >= NOW()";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userUUID = $row['userUUID'];
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE users SET password = '$hashed' WHERE userUUID = '$userUUID'";
        mysqli_query($link, $sqlUpdate);

        $sqlDelete = "DELETE FROM forgotpassword WHERE userUUID = '$userUUID'";
        mysqli_query($link, $sqlDelete);

        echo "<div class='alert alert-success text-center'>Geslo uspešno spremenjeno. Sedaj se lahko prijavite.</div>";
        $showResetForm = false;
    } else {
        echo "<div class='alert alert-danger text-center'>Žeton ni več veljaven.</div>";
    }
}

if (isset($_POST['change'])) {
    $email = $_POST['email'];

    $sql = "SELECT userUUID FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userUUID = $row['userUUID'];

        $token = bin2hex(random_bytes(16));
        $expires = date("Y-m-d H:i:s", time() + 3600);

        mysqli_query($link, "DELETE FROM forgotpassword WHERE userUUID = '$userUUID'");
        mysqli_query($link, "INSERT INTO forgotpassword (userUUID, token, expires) VALUES ('$userUUID', '$token', '$expires')");

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aljaz.skafar1@gmail.com';
            $mail->Password = 'sotz oqsw qxja xuos';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('aljaz.skafar1@gmail.com', 'Aljaž');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Ponastavitev gesla za račun na vici.si';
            $resetLink = "http://localhost/forgotpassword?token=$token";
            $mail->Body = "Pozdravljen/a,<br><br>Za ponastavitev gesla klikni na povezavo:<br><a href='$resetLink'>$resetLink</a><br><br>Povezava velja 1 uro.";
            $mail->send();
            echo "<div class='alert alert-success text-center'>Povezava za ponastavitev gesla je bila poslana na vaš email naslov.</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger text-center'>Pošiljanje e-pošte ni uspelo.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Email naslov ni registriran.</div>";
    }
}

mysqli_close($link);
?>

<div class="mx-4 my-3">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="mb-4 text-center">Pozabljeno geslo</h4>

            <?php if ($showResetForm): ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="password" class="form-label">Novo geslo</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    </div>
                    <button name="reset" type="submit" class="btn btn-success w-100">Shrani novo geslo</button>
                </form>
            <?php else: ?>
                <form method="post">
                    <div class="mb-3">
                        <div class="">Na E-pošto vam bomo poslali link za stran na kateri lahko spremenite geslo.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="email" required>
                    </div>
                    <button name="change" type="submit" class="btn btn-primary w-100">Pošlji</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>
