<?php 
    ob_start(); 
    if ($_SESSION['admin'] != 1) {
        header("Location: /forbidden");
        exit;
    }
?>
<div class="mx-2">
    <div class="row">
        <div class="col-md-2 my-3">
            <div class="list-group">
                <div class="d-flex justify-content-between align-items-center list-group-item border border-dark">
                    <div class="fs-5">Osnutki</div>
                    <form method="post" action="" class="d-inline">
                        <button type="submit" class="btn p-0 m-0 " name="newpost" title="Ustvari novo objavo"><i class="fas fa-plus"></i> Nov</button>
                    </form>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newpost'])) {
                            require_once 'php/db.php';
                            $userUUID = $_SESSION['userUUID'];

                            require_once 'php/uuid.php';
                            $newUUID = generate_uuid_v4();

                            $dateTime = date("Y-m-d H:i:s");

                            $sqlNewDraft = "INSERT INTO posts (contentUUID, userUUID, title, body, public, created, modified) VALUES ('$newUUID', '$userUUID', 'Nov osnutek', '', 0, '$dateTime', '$dateTime')";

                            if (mysqli_query($link, $sqlNewDraft)) {
                                header("Location: ?p=$newUUID");
                                exit;
                            } else {
                                echo "Napaka pri ustvarjanju novega osnutka: " . mysqli_error($link);
                            }
                            mysqli_close($link);
                        }
                    ?>
                </div>
                    <?php
                        require_once 'php/db.php';

                        $sqlDrafts = "SELECT contentUUID, title FROM posts WHERE public = 0 AND userUUID = '" . $_SESSION['userUUID'] . "'";
                        $resultDrafts = mysqli_query($link, $sqlDrafts);

                        if ($resultDrafts) {
                            $drafts = mysqli_fetch_all($resultDrafts, MYSQLI_ASSOC);

                            foreach ($drafts as $draft) {
                                echo "<a href='?p=" . htmlspecialchars($draft['contentUUID']) . "' class='list-group-item border border-dark border-top-0'>" . htmlspecialchars($draft['title']) . "</a>";
                            }

                            mysqli_free_result($resultDrafts);
                        } else {
                            echo "Napaka pri poizvedbi: " . mysqli_error($link);
                        }
                    ?>
            </div>
            <div class="list-group mt-2">
                <div class="d-flex justify-content-between align-items-center list-group-item border border-dark">
                    <div class="fs-5"> Objave</div>
                </div>
                    <?php
                        require_once 'php/db.php';

                        $sqlDrafts = "SELECT contentUUID, title FROM posts WHERE public = 1 AND userUUID = '" . $_SESSION['userUUID'] . "'";
                        $resultDrafts = mysqli_query($link, $sqlDrafts);

                        if ($resultDrafts) {
                            $drafts = mysqli_fetch_all($resultDrafts, MYSQLI_ASSOC);

                            foreach ($drafts as $draft) {
                                echo "<a href='?p=" . htmlspecialchars($draft['contentUUID']) . "' class='list-group-item border border-dark border-top-0'>" . htmlspecialchars($draft['title']) . "</a>";
                            }

                            mysqli_free_result($resultDrafts);
                        } else {
                            echo "Napaka pri poizvedbi: " . mysqli_error($link);
                        }
                    ?>
            </div>
        </div>
        <div class="col-md-10 my-3">
            <div class="container col-md-8 bg-white border border-dark rounded ms-0">
                <?php
                    if (isset($_GET['p'])) {
                        $contentUUID = mysqli_real_escape_string($link, $_GET['p']);

                        $sqlPost = "SELECT title, body, category FROM posts WHERE contentUUID = '$contentUUID' AND userUUID = '" . $_SESSION['userUUID'] . "'";
                        $resultPost = mysqli_query($link, $sqlPost);

                        if ($resultPost && mysqli_num_rows($resultPost) > 0) {
                            $post = mysqli_fetch_assoc($resultPost);
                            include 'editor.html.php';
                        } else {
                            echo "Objava ni bila najdena ali pa zanjo nimate pravic.";
                        }
                    } else {
                        echo "Izberite opcijo v meniju";
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>