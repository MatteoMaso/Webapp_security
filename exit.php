<?php
	// set the expiration date to one hour ago
	setcookie("user", "", time() - 3600);
	setcookie("password", "", time() - 3600);
	header("Location: login.php");
?>
