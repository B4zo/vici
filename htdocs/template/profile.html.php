<?php ob_start();?>
<div class="mx-4 my-3">
    <div class="row">
        <div class="col-md-2"> 
            <div class="d-flex list-group-item border-dark">
                <a href="/changepassword" class="btn btn-light btn-outline-dark fs-5">Spremeni geslo</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="fs-5">Pozdravljen, <?php echo $_SESSION['username']?>!</div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require "template/layout.html.php";
?>
