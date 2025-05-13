<?php ob_start()?>
<?php
    require_once 'php/db.php';
    $sqlContent = "SELECT posts.title, posts.body, users.username FROM posts JOIN users ON posts.userUUID = users.userUUID WHERE posts.public = 1 ORDER BY posts.created;";
    $resultContent = mysqli_query($link, $sqlContent);

    $posts = mysqli_fetch_all($resultContent, MYSQLI_ASSOC);

    mysqli_close($link);
?>
<div class="container-fluid my-4">
    <div class="row g-4">
        <?php
        foreach ($posts as $post) {
            echo "<div class='col-md-4'>";
                echo "<div class='card h-100 shadow-sm border-dark' style='min-height: 300px;'>";
                    echo "<div class='card-body d-flex flex-column'>";
                        echo "<h4 class='card-title'>" . htmlspecialchars($post['title']) . "</h4>";
                        echo "<h6 class='card-text mb-0'> Objavil/-a:  " . htmlspecialchars($post['username']) . "</h6>";
                        echo "<p class='card-text mb-0 truncate-multiline'>" . nl2br(htmlspecialchars($post['body'])) . "</p>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>


<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>