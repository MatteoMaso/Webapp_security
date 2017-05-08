<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a class="navbar-brand" href="index.php" title="Home">Check List</a>
		</div>

		<div id="navbar" class="navbar-collapse collapse navbar-form navbar-right">
			<?php
				if(isset($_COOKIE["user"])) {
					echo "<a class=\"btn btn-default\" style=\"margin-right: 5px;\" href=\"private.php\" title=\"Private\">Dashboard</a>";
					echo "<a class=\"btn btn-danger\" href=\"exit.php\" title=\"Logout\">Sign out</a>";
				} else {
					echo "<a class=\"btn btn-success\" href=\"login.php\" title=\"Login\">Sign in</a>";
				}
			?>
		</div><!--/.navbar-collapse -->
	</div>
</nav>
