<?php

  include "database.php";

  $email = $_POST["email"];
  $name = $_POST["name"];
  $password = $_POST["password"];


  $sql = "INSERT INTO users (email, name, password) VALUES ("$email", "$name", "$password");";
	$result = mysql_query($sql, $link);

  if ($result == false) {
		include "src/header.php";
		include "src/mainmenu.php";
		echo '<p>Unfortunally something was wrong :-(</p>';
		echo '<p><a href="sing_up.php">Try again</a></p>';
		include "src/footer.php";
		exit;
	}
	else {
		header('Location: private.php');
	}

	mysql_close($link);


?>
