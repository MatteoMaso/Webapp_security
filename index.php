<?php
	session_start();

	include "src/header.php";
	include "src/mainmenu.php";
	include "database.php"
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h1>Hello!</h1>
		<h2>Welcome to notes</h2>
		<p>You can take note of everything in the app. We ensure the most PRIVACY and SECURITY of your notes.</p>
		<p>
			<a class="btn btn-primary btn-lg" href="sign_up.php" title="Sign_up">Sign up »</a>
		</p>
	</div>
</div>

<?php


echo '<br/> <br/> <form class="init" name="form_init" method="post">
  <input type="submit" name="initUser" value="Reset and Initialize Users List Before start Haking" onclick="initUsers()"/>
</form>';

if(isset($_POST['initUser'])){
  $database = getConn();

  $sql = "DELETE FROM users";
  $result = $database->query($sql);

  $sql = "DELETE FROM tasks";
  $result = $database->query($sql);

  $sql = "INSERT INTO users (email, username, password) VALUES ('john@example.com', 'John', 'Dodo');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('mary@example.com', 'Mary', 'Mary96');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('matteo@example.com', 'matteo', 'pippo');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('jusy@example.com', 'giu', 'giugiu21');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('vale87@example.com', 'vales', 'ValesVales');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('nicola@example.com', 'nik', 'c834cola');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('pino@example.com', 'pino', 'three32');";

  $result = $database->query($sql);
  if ($database->multi_query($sql) === TRUE) {
    echo "Users list create correctly!";
  } else {
    echo "Error: " . $sql . "<br>" . $database->error;
  }
  $database->close();
}

include_once "src/footer.php";
?>
