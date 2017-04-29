<?php
	if(!(isset($_SESSION['login']) && $_SESSION['login'] == "OK")) {

	include "database.php";
	include "src/header.php";
	include "src/mainmenu.php";
	$cookie_name = "user";
	$username = "";
	//check if cookie are enable
	if(count($_COOKIE) > 0) {
    //echo "Cookies are enabled.";
		$username = $_COOKIE[$cookie_name];
	} else {
    //echo "Cookies are disabled.";
	}
	echo '<h2>Welcome ' . $_COOKIE[$cookie_name] . '!</h2>';
	}

	$task = $taskErr = "";
	$ok = 0;

	if ($_SERVER["REQUEST_METHOD"] == "GET"){
			//echo "get invocato";
			$donelist = isset($_GET['list']) ? $_GET['list'] : array();

			if (!count($donelist)) {echo 'Errore! Devi selezionare almeno un interesse';
			} else {
					foreach($donelist as $donetask) {
						$element = explode('/', $donetask);
    				$result = removeTask($username, $element[0]);
						//echo "ricevuto get -".$donetask."--";
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

	function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


	function printTask($username){
		$database = getConn();
		createTable(); //create table if not exist
		$sql = "SELECT * FROM tasks";
		$result = $database->query($sql);
		if ($result->num_rows >0){
			// output data of each row
			while($row = $result->fetch_assoc()) {
				if(($row["username"] == $username) && ($row["done"] == '0')){
					echo " id ".$row["id"]. "<input type='checkbox' name='list[]' value=" .$row["task"]."/>".$row["task"]."<br/><br/>";
				}
			}
		}
		$database->close();;
	}

	function removeTask($username, $task){
		$database = getConn();
		$sql = "UPDATE tasks SET done='boh' WHERE username='$username' AND task='$task'";
		$result = $database->query($sql);

		$database->close();;
	}

	function addTask($username, $task) {
		$database = getConn();
		$str = str_replace(" ", "_", $task);
		$query = "INSERT INTO tasks (username, task, done) VALUES ('$username', '$str', '0')";
		$result = mysqli_query($database, $query);
		mysqli_close($database);
		//printTask($username);
		return $result;
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

	<p><a href="exit.php">Exit</a></p>
<?php
	include "src/footer.php";
?>
