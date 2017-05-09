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

<?php include_once "src/footer.php"; ?>
