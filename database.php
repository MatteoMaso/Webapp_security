<?php
	function getConn(){
        $database = mysqli_connect("eu-cdbr-west-01.cleardb.com", "bef9d47da2d4c7", "c23f5d36", "heroku_75ff61745485cbc");
        if (!$database) {
            die("Connection failed: " . mysqli_connect_error());
            return null;
        }

        return $database;
    }

		function createTable(){
			$database = getConn();
			$sql = "CREATE TABLE IF NOT EXISTS tasks(
			  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			  username VARCHAR(512) NOT NULL,
			  task VARCHAR(512) NOT NULL,
			  done VARCHAR(512) NOT NULL
			)";

			if ($database->query($sql) === TRUE) {
    		//echo "Table Tasks created successfully <br>";
			} else {
    		echo "Error creating table: " . $database->error;
			}
			$database->close();
		}


    function checkUsername($username) {
    	$database = getConn();

    	$username = mysqli_real_escape_string ($database, $username);

        $query = "SELECT *  FROM users WHERE username = '$username'";
        $result = mysqli_query($database, $query);

        mysqli_close($database);

        if (!$result || mysqli_num_rows($result) > 0) {
            //echo "// Username is already taken!";
            return false;
        } else {
            //echo "// Username is available!";
            return true;
        }
    }

		//return 1 if username is correct else return 0
		function verifyUser($username, $password){
			$database = getConn();
			$sql = "SELECT id, username, password FROM users WHERE username='$username'";
			$result = $database->query($sql);
			$verify = 0;

			if ($result->num_rows >0){
				// output data of each row
    		while($row = $result->fetch_assoc()) {
					if($row["password"] == $password){
        	//	echo "id: " . $row["id"]. " - Username: " . $row["username"]. " " . $row["password"]. "<br>";
						$database->close();
						return 1; //usercorrect
					}
    		}
				echo "Please retry password \n";
			} else {
    		echo "Please retry username wrong \n";
			}

			$database->close();
			return 0; //user incorrect
		}


    // Test
    //checkUsername("hello");
    //resetDatabase();
    //testConn();
 ?>
