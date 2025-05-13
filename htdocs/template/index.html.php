<?php ob_start()?>
<?php
    require_once 'php/db.php';
    $sqlContent = "SELECT posts.title, posts.body, users.username FROM posts JOIN users ON posts.userUUID = users.userUUID WHERE posts.public = 1 ORDER BY posts.created LIMIT 3;";
    $resultContent = mysqli_query($link, $sqlContent);

    $postsRec = mysqli_fetch_all($resultContent, MYSQLI_ASSOC);

    $sqlCat = "
        (SELECT posts.title, posts.body, users.username, posts.created, category.category 
        FROM posts 
        JOIN users ON posts.userUUID = users.userUUID 
        JOIN category ON posts.category = category.id 
        WHERE posts.public = 1 AND posts.category = 2 
        ORDER BY posts.created DESC LIMIT 1)
        
        UNION ALL

        (SELECT posts.title, posts.body, users.username, posts.created, category.category 
        FROM posts 
        JOIN users ON posts.userUUID = users.userUUID 
        JOIN category ON posts.category = category.id 
        WHERE posts.public = 1 AND posts.category = 3 
        ORDER BY posts.created DESC LIMIT 1)
        
        UNION ALL

        (SELECT posts.title, posts.body, users.username, posts.created, category.category 
        FROM posts 
        JOIN users ON posts.userUUID = users.userUUID 
        JOIN category ON posts.category = category.id 
        WHERE posts.public = 1 AND posts.category = 4 
        ORDER BY posts.created DESC LIMIT 1);
    ";
    $resultCat = mysqli_query($link, $sqlCat);
    $postsCat = mysqli_fetch_all($resultCat, MYSQLI_ASSOC);

    mysqli_close($link);
?>
<div class="container-fluid my-4">
    <div class="container-fluid my-3">
        
        <?php 
            if(isset($_SESSION['username'])) {
                echo "<h2>Pozdravljeni " . $_SESSION['username']. "!</h2>";
            } else {
                echo "<h2>Pozdravljeni!</h2>";
            }
        ?>
    </div>
    <div class="mb-5">
        <div class="container-fluid my-2">
            <h3> Vici po kategorijah </h3>
        </div>
        <div class="row g-4">
            <?php
                foreach ($postsCat as $postCat) {
                    echo "<div class='col-md-4'>";
                        echo "<div class='card h-100 shadow-sm border-dark' style='min-height: 300px;'>";
                            echo "<div class='card-body d-flex flex-column'>";
                                echo "<h3 class='card-title '>" . htmlspecialchars($postCat['category']) . "</h3>";
                                echo "<h4 class='card-title'>" . htmlspecialchars($postCat['title']) . "</h4>";
                                echo "<h6 class='card-text mb-0'> Objavil/-a:  " . htmlspecialchars($postCat['username']) . "</h6>";
                                echo "<p class='card-text mb-0 truncate-multiline'>" . nl2br(htmlspecialchars($postCat['body'])) . "</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
    <div class="container-fluid my-2">
        <h3> Zadnji objavleni vici </h3>
    </div>
    <div class="row g-4">
        <?php
        foreach ($postsRec as $postRec) {
            echo "<div class='col-md-4'>";
                echo "<div class='card h-100 shadow-sm border-dark' style='min-height: 300px;'>";
                    echo "<div class='card-body d-flex flex-column'>";
                        echo "<h4 class='card-title'>" . htmlspecialchars($postRec['title']) . "</h4>";
                        echo "<h6 class='card-text mb-0'> Objavil/-a:  " . htmlspecialchars($postRec['username']) . "</h6>";
                        echo "<p class='card-text mb-0 truncate-multiline'>" . nl2br(htmlspecialchars($postRec['body'])) . "</p>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <div class="d-flex">
        <a href="/recents" class="btn btn-light border-dark my-3 ms-auto">Več zadnjih objav</a>
    </div>
</div>


<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>