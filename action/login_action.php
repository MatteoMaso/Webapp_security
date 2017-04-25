<?php
  session_start();

  include "../database.php";

  $username = $_POST["username"];
  $password = $_POST["password"];

  $verific = userLogin($username, $password);
  echo "Login avvenuto con successo "  .$verific. "?\n";

  function userLogin($username, $password){
    $database = getConn();
    $query = "SELECT username, password FROM users WHERE username = '$username' and password = '$password'";

    $result = mysqli_query($database, $query);
    if ($result == false) {
		    echo '<a href="../login.php">Error: cannot execute query</a>';
		    return false;
	  } else {

      $num_rows = mysqli_num_rows($result);

      if ($num_rows >= 1) {
		      $_SESSION['login'] = "OK";
		      $_SESSION['username'] = $username;
		      header('Location: ../private.php');
          return 1;
      } else {
          return 0;
      }
    }

    $database->close();
  }
?>
