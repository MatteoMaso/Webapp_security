<?php
	include "database.php";
	include "src/header.php";
	include "src/mainmenu.php";
	$cookie_name = "user";
	$cookie_password = "password";
	$username = $task = $taskErr = "";

	//check if cookie are enable
	if((count($_COOKIE) > 0) && !(checkUsername($_COOKIE[$cookie_name]))) {
		$username = $_COOKIE[$cookie_name];
		$ok = 0;
			echo '<h2>Welcome ' . $_COOKIE[$cookie_name]. '!</h2>';
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
		        $taskErr = "Name is required";
		    } else {
		        $task = test_input($_POST["task"]);
		        $ok = $ok+1;
						if (!preg_match("/^[a-zA-Z ]*$/", $task)) {
		          $taskErr = "Only letters and white space allowed";
		          $ok = $ok-1;
		        }
		    }
				if($ok == 1){ //if control are ok => add task
					$control = addTask($username, $task);
				}
			}
		} else {
			echo "Something was wrong";
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
					createTable(); //create table if not exist
					$sql = "SELECT * FROM tasks";
					$result = $database->query($sql);
					if ($result->num_rows >0){
						// output data of each row
						while($row = $result->fetch_assoc()) {
							if(($row["username"] == $username) && ($row["done"] == '0')){
								$task_without_underscore = str_replace("_", " ", $row["task"]);
								echo " id ".$row["id"]. "<input type='checkbox' name='list[]' value=" .$row["task"]."/>".$task_without_underscore ."<br/><br/>";
							}
						}
					}
					$database->close();
			}
		}

		function removeTask($username, $task){
			if(verifyUser($username, $_COOKIE["password"]) == 1){
						$database = getConn();
						$sql = "UPDATE tasks SET done='boh' WHERE username='$username' AND task='$task'";
						$result = $database->query($sql);
						$database->close();
					}
		}

		function addTask($username, $task) {
			if(verifyUser($username, $_COOKIE["password"]) == 1){
					$database = getConn();
					$str = str_replace(" ", "_", $task);
					$query = "INSERT INTO tasks (username, task, done) VALUES ('$username', '$str', '0')";
					$result = mysqli_query($database, $query);
					mysqli_close($database);
					//printTask($username);
					return $result;
			}
		}
?>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
		<fieldset>
			<?php printTask($username); ?>
			<p class="center"><input value="Task done!" type="submit" /></p>
		</fieldset>
	</form>


	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<fieldset>
			<legend>New task</legend>
			<p>
				<label for="task">Task:</label> <input type="task" name="task" id="task" />
				<span class="error">* <?php echo $taskErr;?></span>
			</p>
			<p class="center"><input value="Save" type="submit" /></p>
		</fieldset>
	</form>


	<form class="exit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="submit" name="exit" value="Exit"  id="exit" />
	</form>


<?php

function exit_user(){
	echo "dento exit";
	setcookie("user", "", time() - (3600), "/");
  setcookie("password", "", time() - 3600, "/");
  header("Location: login.php");
}

if(array_key_exists('exit', $_POST)){
	exit_user();
}

	include "src/footer.php";
?>
