<?php ob_start()?>
<div>
    <h1 class="mx-3  my-2">404 - Neobstaja</h1>
    <p class="mx-5 fs-4">Če je to napaka kontaktirajte administracijo.</p>
</div>
<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>