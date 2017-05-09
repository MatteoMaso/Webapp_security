<?php
	include "database.php";
	include "src/header.php";
	include "src/mainmenu.php";
	$cookie_name = "user";
	$cookie_password = "password";
	$username = $task = $taskErr = "";

	if (!isset($_COOKIE[$cookie_name])) {
		header('Location: login.php');
	}
	//check if cookie are enable
	if((count($_COOKIE) > 0) && !(checkUsername($_COOKIE[$cookie_name]))) {
		$username = $_COOKIE[$cookie_name];
		$ok = 0;
		//echo '<h2>Welcome ' . $_COOKIE[$cookie_name]. '!</h2>';
		if ($_SERVER["REQUEST_METHOD"] == "GET"){
			$donelist = isset($_GET['list']) ? $_GET['list'] : array();
			if (!count($donelist)) {
				//do nothing
			} else {
					foreach($donelist as $donetask) {
						$element = explode('/', $donetask);
    				$result = removeTask($username, $element[0]);
  				}
			}
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST"){
		    if (empty($_POST["task"])) {
		        $taskErr = "Note content should not be empty.";
		    } else {
		        $task = test_input($_POST["task"]);
		        $ok = $ok+1;
				if (!preg_match("/^[a-zA-Z ]*$/", $task)) {
		          $taskErr = "Only letters and white space allowed";
		          $ok = $ok-1;
		        }
		    }

			if($ok == 1) { //if control are ok => add task
				$control = addTask($username, $task);
			}
		}
	} else {
		//echo "Something was wrong";
		header('Location: exit.php');
	}


	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	function printTask($username){
		if(verifyUser($username, $_COOKIE["password"]) == 1){
			$database = getConn();
			//createTable(); //create table if not exist
			$sql = "SELECT * FROM notes";
			$result = $database->query($sql);
			if ($result->num_rows >0){
				// output data of each row
				while($row = $result->fetch_assoc()) {
					if(($row["username"] == $username) && ($row["done"] == '0')){
						$task_without_underscore = str_replace("_", " ", $row["note"]);
						$task_id = $row["id"];
						$task_val = $row["note"];
						echo "<tr><td><input type=\"checkbox\" name=\" list[]\" value=\"$task_val\"/></td><td>$task_id</td><td>$task_without_underscore</td></tr>";
						//echo " id ".$row["id"]. "<input type='checkbox' name='list[]' value=" .$row["task"]."/>".$task_without_underscore ."<br/><br/>";
					}
				}
			}
			$database->close();
		}
	}

	function removeTask($username, $task){
		if(verifyUser($username, $_COOKIE["password"]) == 1){
			$database = getConn();
			$sql = "UPDATE notes SET done=TRUE WHERE username='$username' AND note='$task'";
			$result = $database->query($sql);
			$database->close();
		}
	}

	function addTask($username, $task) {
		if(verifyUser($username, $_COOKIE["password"]) == 1){
			$database = getConn();
			$str = str_replace(" ", "_", $task);
			$query = "INSERT INTO notes (username, note, done) VALUES ('$username', '$str', '0')";
			$result = mysqli_query($database, $query);
			mysqli_close($database);
			//printTask($username);
			return $result;
		}
	}
?>
<div class="container">
	<h1>Welcome, <?php echo $_COOKIE[$cookie_name] ?>!</h1>

	<div class="col-sm-12">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<h3 class="sub-header">Add new note</h3>

			<label for="inputContent" class="sr-only">Task content</label>
			<input type="text" id="inputContent" name="task" class="form-control" placeholder="Task content" required="" autofocus="">

			<input class="btn btn-warning" style="margin-top: 10px;" value="Save" type="submit" />
		</form>
	</div>

	<?php if ($taskErr != "") echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Note content error: $taskErr</p>"; ?>

	<div class="col-sm-12">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
			<h3 class="sub-header">Note list</h3>
			<table class="table table-striped">
				<thead>
					<tr>
						<th></th>
						<th>#</th>
						<th>Content</th>
					</tr>
	            </thead>

	            <tbody>
	            	<?php printTask($username); ?>
	            	<!--tr>
	            		<td></td>
	            		<td>1</td>
	            		<td>Lorem</td>
	            	</tr-->
	            </tbody>
	        </table>

			<input class="btn btn-danger" style="margin-top: 10px;" value="Delete" type="submit" />
		</form>
	</div>

	<div class="col-sm-12">
		<h3 class="sub-header">Find done notes</h3>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
				<label for="inputFind" class="sr-only">Task content</label>
				<input type="text" id="inputFind" name="find" class="form-control" placeholder="Task content" required="" autofocus="">
				<input class="btn btn-info" style="margin-top: 10px;" value="Find" type="submit" />
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "GET"){
					    if (empty($_GET["find"])) {
					        $taskErr = "Finding content should not be empty.";
					    } else {
					        $task = test_input($_GET["find"]);
					    }
						
						$database = getConn();
						$sql = "SELECT * FROM notes WHERE note LIKE '%$task%' AND username = '$username' AND done = TRUE";
						echo "<p style=\"margin-top: 10px;\"><b>Raw query:</b> $sql</p>";
						$result = $database->query($sql);

						echo "<p style=\"margin-top: 10px;\"><b>Rows count:</b> $result->num_rows</p>";

						if ($result->num_rows > 0){
							echo "<table class=\"table table-striped\"><thead><tr><th>#</th><th>Content</th></tr></thead><tbody>";
							// output data of each row
							while($row = $result->fetch_array()) {
								//$task_without_underscore = str_replace("_", " ", $row[2]);
								$task_note = $row[2];
								$task_id = $row[0];
								//echo "<tr>$row[0]</tr>";
								echo "<tr><td>$row[0]</td><td>$row[2]</td></tr>";
							}
							echo "</tbody></table>";
						}

					}
				?>
			</form>
	</div>
</div>

<?php include_once "src/footer.php"; ?>
