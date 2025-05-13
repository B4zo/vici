<?php ob_start(); ?>
<div class="container">
    <?php
        require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
        require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
        require_once __DIR__ . '/../PHPMailer/src/Exception.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        if (isset($_POST['signup'])) {
            $username = strip_tags(trim($_POST['username']));
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];
            $email = $_POST['email'];

            $hCaptchaResponse = $_POST['h-captcha-response'];
            $secretKey = "ES_e8f9644a352a421ab3362a338a7e9e5a";
            $data = array(
                'secret' => $secretKey,
                'response' => $hCaptchaResponse
            );

            $verify = curl_init();
            curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
            curl_setopt($verify, CURLOPT_POST, true);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

            $hCaptcharesponse = curl_exec($verify);
            $hCaptcharesponseResponseData = json_decode($hCaptcharesponse);
            
            require_once 'php/db.php';
            $sqlUsername = "SELECT username, email FROM users WHERE username = '$username'";
            $resultUsername = mysqli_query($link, $sqlUsername);

            if (!$hCaptcharesponseResponseData->success){
                echo "<div class='alert alert-danger' role='alert'>Captcha validacija ni uspela.</div>";
            } else if (empty($username) || empty($password) || empty($passwordConfirm)) {
                echo "<div class='alert alert-danger' role='alert'>Niste izpolnili vseh polj!</div>";
            } elseif (strlen($username) > 30) {
                echo "<div class='alert alert-danger' role='alert'>Uporabniško ime je predolgo!</div>";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='alert alert-danger' role='alert'>Email ni validen!</div>";
            } elseif (strlen($password) < 8) {
                echo "<div class='alert alert-danger' role='alert'>Geslo je prekratko</div>";
            } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
                echo "<div class='alert alert-danger' role='alert'>Geslo mora vsebovati črke, številke in posebne znake.</div>";
            } elseif ($password !== $passwordConfirm) {
                echo "<div class='alert alert-danger' role='alert'>Gesli se ne ujemata!</div>";
            } else {
                require_once 'php/db.php';
                $sqlUsername = "SELECT username FROM users WHERE username = '$username'";
                $resultUsername = mysqli_query($link, $sqlUsername);

                if (mysqli_num_rows($resultUsername) > 0) {
                    echo "<div class='alert alert-danger' role='alert'>Uporabniško ime je že uporabljeno!</div>";
                } else {
                    require_once 'php/db.php';
                    $sqlEmail = "SELECT email FROM users WHERE email = '$email'";
                    $resultEmail = mysqli_query($link, $sqlEmail);

                    if (mysqli_num_rows($resultEmail) > 0) {
                        echo "<div class='alert alert-danger' role='alert'>Email je že uporabljen!</div>";
                    } else {
                        $hPassword = password_hash($password, PASSWORD_DEFAULT);
                        $dateTime = date("Y-m-d H:i:s");

                        require_once 'php/uuid.php';
                        
                        $userUUID = generate_uuid_v4();

                        $sqlSignUp = "INSERT INTO users (userUUID, username, email, password, created, verified) VALUES ('$userUUID','$username', '$email', '$hPassword', '$dateTime', 0)";

                        if (mysqli_query($link, $sqlSignUp)) {
                            $token = bin2hex(random_bytes(16));

                            $sqlVerify = "INSERT INTO verification (userUUID, token) VALUES ('$userUUID', '$token')";
                            mysqli_query($link, $sqlVerify);

                            $verificationLink = "https://localhost/verify?token=$token";
                            
                            $mail = new PHPMailer(true);

                            try {
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'aljaz.skafar1@gmail.com';
                                $mail->Password   = 'sotz oqsw qxja xuos';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port       = 587;

                                $mail->setFrom('aljaz.skafar1@gmail.com', 'Aljaž');
                                $mail->addAddress($email, $username);

                                $mail->isHTML(true);
                                $mail->Subject = 'Verifikacija vašega računa na vici.si';

                                $mail->Body = "
                                    <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                                        <h2 style='color: #333;'>Pozdravljeni, $username!</h2>
                                        <p>Hvala za registracijo na <strong>vici.si</strong>.</p>
                                        <p>Za potrditev vašega računa kliknite spodnjo povezavo:</p>
                                        <p>
                                            <a href='$verificationLink' style='display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>
                                                Potrdi račun
                                            </a>
                                        </p>
                                        <p>Če povezava ne deluje, jo lahko kopirate in prilepite v brskalnik:</p>
                                        <p><a href='$verificationLink'>$verificationLink</a></p>
                                        <hr>
                                        <p style='font-size: 0.9em; color: #666;'>Če se niste registrirali na vici.si, to sporočilo prezrite.</p>
                                    </div>
                                ";

                                $mail->AltBody = "Pozdravljeni, $username!\n\nKliknite povezavo za potrditev vašega računa:\n$verificationLink\n\nČe se niste registrirali, prezrite to sporočilo.";

                                $mail->send();
                                echo "<div class='alert alert-success' role='alert'>Registracija uspešna! Preverite svojo e-pošto za potrditveno povezavo.</div>";
                            } catch (Exception $e) {
                                echo "<div class='alert alert-danger' role='alert'>Napaka pri pošiljanju e-pošte: {$mail->ErrorInfo}</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Napaka pri registraciji uporabnika.</div>";
                        }
                    }

                }
                mysqli_close($link);
            }
        }
    ?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="mb-4 text-center">Ustvari račun</h4>
            <form method="post">
                <div class="mb-3">
                    <label for="Username" class="form-label">Uporabniško ime</label>
                    <input name="username" type="text" class="form-control" id="Username" required>
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="Email" required>
                </div>
                <div class="mb-3">
                    <label for="Password1" class="form-label">Geslo</label>
                    <input name="password" type="password" class="form-control" id="Password1" required>
                </div>
                <div class="mb-3">
                    <label for="Password2" class="form-label">Ponovi geslo</label>
                    <input name="passwordConfirm" type="password" class="form-control" id="Password2" required>
                </div>
                <div class="mb-4 d-flex justify-content-left">
                    <div class="h-captcha" data-sitekey="8f0876c4-fa12-4440-8a66-5ab653aa8c32"></div>
                </div>
                <button name="signup" type="submit" class="btn btn-primary w-100">Registriraj se</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>