<?php
	$link = new mysqli("localhost", "root", "", "vici");
	if ($link->connect_error) {
		die("Povezava ni uspela: " . $link->connect_error);
	}
?>