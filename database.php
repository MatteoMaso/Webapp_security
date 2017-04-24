<?php
	function getConn(){
        $database = mysqli_connect("eu-cdbr-west-01.cleardb.com", "bef9d47da2d4c7", "c23f5d36", "heroku_75ff61745485cbc");
        if (!$database) {
            die("Connection failed: " . mysqli_connect_error());
            return null;
        }

        return $database;
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

    // Test
    //checkUsername("hello");
    //resetDatabase();
    //testConn();
 ?>
