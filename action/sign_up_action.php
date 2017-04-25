<?php

  include "../database.php";

  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = $_POST["password"];

  //control if username is available
  $control = checkUsername($username);
  if ($control == false) {
    include "../src/header.php";
    //include "../src/mainmenu.php";
    echo '<p>Error: Please choose other Username</a>';
		echo '<p><a href="../sign_up.php">Try again</p>';
		include "../src/footer.php";
		exit;
	} else {
    $control = addUser($email, $username, $password);
    echo "result = $control";
    header('Location: ../private.php');
	}


  //this function have to move to database.php and add controll on string
  function addUser($email, $username, $password) {

    $database = getConn();
    $query = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";
    $result = mysqli_query($database, $query);

    mysqli_close($database);
    return $result;
  }

?>
