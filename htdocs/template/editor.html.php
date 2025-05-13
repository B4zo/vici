<?php ob_start(); ?>
<div class="mb-4 mt-3 ms-4">
    <h2 class="fs-3">Urejanje</h2>
</div>
<div class="row mx-5 mt-2">
    <div class="col-md-8 ">
        <form method="post">
            <div class="mb-3">
                <label for="Title" class="form-label">Naslov</label>
                <input type="text" class="form-control" id="Title" name="title" placeholder="Vnesi naslov vica" value="<?= htmlspecialchars($post['title'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="vsebina" class="form-label">Vsebina</label>
                <textarea class="form-control" rows="5" id="vsebina" name="vsebina" placeholder="Vnesi vsebino vica"><?= htmlspecialchars($post['body'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategorija</label>
                <select class="form-select" id="category" name="category">
                    <option value="1" <?= (isset($post['category']) && $post['category'] == 1) ? 'selected' : '' ?>>Brez</option>
                    <option value="2" <?= (isset($post['category']) && $post['category'] == 2) ? 'selected' : '' ?>>Blondinka</option>
                    <option value="3" <?= (isset($post['category']) && $post['category'] == 3) ? 'selected' : '' ?>>Policijski</option>
                    <option value="4" <?= (isset($post['category']) && $post['category'] == 4) ? 'selected' : '' ?>>Janezek</option>
                </select>
            </div>
            <div class="ms-auto d-flex">
                <button type="submit" class="btn btn-light btn-outline-dark px-4 me-3 mb-2" name="save"><i class="fas fa-save"></i> Shrani</button>
                <?php 
                    require_once 'php/db.php';

                    if (isset($_GET['p'])) {
                        $contentUUID = mysqli_real_escape_string($link, $_GET['p']);
                        $sqlVisibility = "SELECT public FROM posts WHERE contentUUID = '$contentUUID' AND userUUID = '" . $_SESSION['userUUID'] . "' LIMIT 1";
                        $resultVisibility = mysqli_query($link, $sqlVisibility);
                        
                        if ($resultVisibility && $visibility = mysqli_fetch_assoc($resultVisibility)) {
                            if ($visibility['public'] == 1) {
                                echo '<button type="submit" class="btn btn-light btn-outline-dark px-4 me-3 mb-2" name="hide"><i class="fas fa-eye-slash"></i> Skrij</button>';
                            } else {
                                echo '<button type="submit" class="btn btn-light btn-outline-dark px-4 me-3 mb-2" name="publish"><i class="fas fa-check"></i> Objavi</button>';
                            }
                        } else {
                            echo '<div class="alert alert-danger mt-3">Napaka pri pridobivanju objave.</div>';
                        }
                    }
                ?>
                <button type="submit" class="btn btn-light btn-outline-dark px-4 mb-2" name="delete"><i class="fas fa-trash"></i> Izbriši</button>
            </div>
        </form>
        <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                require_once 'php/db.php';

                $title = mysqli_real_escape_string($link, $_POST['title']);
                $body = mysqli_real_escape_string($link, $_POST['vsebina']);
                $dateTime = date("Y-m-d H:i:s");
                $contentUUID = mysqli_real_escape_string($link, $_GET['p']);
                $category = mysqli_real_escape_string($link, $_POST['category']);

                $sqlUpdate = "UPDATE posts SET title = '$title', body = '$body', modified = '$dateTime', category = '$category' WHERE contentUUID = '$contentUUID' AND userUUID = '" . $_SESSION['userUUID'] . "'";

                if (mysqli_query($link, $sqlUpdate)) {
                    echo "<div class='alert alert-success mt-3'>Osnutek uspešno shranjen.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Napaka pri shranjevanju: " . mysqli_error($link) . "</div>";
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publish'])) {
                require_once 'php/db.php';

                $title = mysqli_real_escape_string($link, $_POST['title']);
                $body = mysqli_real_escape_string($link, $_POST['vsebina']);
                $dateTime = date("Y-m-d H:i:s");
                $contentUUID = mysqli_real_escape_string($link, $_GET['p']);
            
                $sqlPublish = "UPDATE posts SET title = '$title', body = '$body', public = 1, modified = '$dateTime' WHERE contentUUID = '$contentUUID' AND userUUID = '" . $_SESSION['userUUID'] . "'";
            
                if (mysqli_query($link, $sqlPublish)) {
                    header("Location: studio?p=" . urlencode($contentUUID));
                    exit;
                } else {
                    echo "<div class='alert alert-danger mt-3'>Napaka pri objavi: " . mysqli_error($link) . "</div>";
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hide'])) {
                require_once 'php/db.php';

                $title = mysqli_real_escape_string($link, $_POST['title']);
                $body = mysqli_real_escape_string($link, $_POST['vsebina']);
                $dateTime = date("Y-m-d H:i:s");
                $contentUUID = mysqli_real_escape_string($link, $_GET['p']);
            
                $sqlHide = "UPDATE posts SET title = '$title', body = '$body', public = 0, modified = '$dateTime' WHERE contentUUID = '$contentUUID' AND userUUID = '" . $_SESSION['userUUID'] . "'";
            
                if (mysqli_query($link, $sqlHide)) {
                    header("Location: studio?p=" . urlencode($contentUUID));
                    exit;
                } else {
                    echo "<div class='alert alert-danger mt-3'>Napaka pri skrivanju: " . mysqli_error($link) . "</div>";
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                require_once 'php/db.php';
            
                $contentUUID = mysqli_real_escape_string($link, $_GET['p']);
            
                $sqlDelete = "DELETE FROM posts WHERE contentUUID = '$contentUUID' AND userUUID = '" . $_SESSION['userUUID'] . "'";
            
                if (mysqli_query($link, $sqlDelete)) {
                    header("Location: studio");
                    exit;
                } else {
                    echo "<div class='alert alert-danger mt-3'>Napaka pri brisanju: " . mysqli_error($link) . "</div>";
                }
            }            
        ?>
    </div>
</div>
<?php
    mysqli_close($link);
    echo ob_get_clean();
?>
