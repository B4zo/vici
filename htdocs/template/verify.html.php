<?php
ob_start();

$verified = false;
$invalid = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    require_once 'php/db.php';

    $sql = "SELECT userUUID FROM verification WHERE token = '$token'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userUUID = $row['userUUID'];

        $sqlVerify = "UPDATE users SET verified = 1 WHERE userUUID = '$userUUID'";
        mysqli_query($link, $sqlVerify);

        $sqlDelete = "DELETE FROM verification WHERE token = '$token'";
        mysqli_query($link, $sqlDelete);

        $verified = true;
    } else {
        $invalid = true;
    }

    mysqli_close($link);
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php
            if ($verified) {
                echo "<div class='alert alert-success text-center'>Račun uspešno verificiran. Sedaj se lahko prijavite.</div>";
            } elseif ($invalid) {
                echo "<div class='alert alert-danger text-center'>Neveljaven ali že uporabljen verifikacijski žeton.</div>";
            } else {
                echo "<div class='alert alert-info text-center'>Manjka verifikacijski žeton.</div>";
            }
            ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>
