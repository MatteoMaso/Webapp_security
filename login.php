<?php
  include "src/header.php";
  include "src/mainmenu.php";

  $usernameErr =  $passwordErr = "";
  $username =  $password = "";
  $ok = 0; //check variable

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        // check if name only contains letters and whitespace
        $ok = $ok+1;
        if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
          $usernameErr = "Only letters and white space allowed";
          $ok = $ok-1;
        }
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        $ok = $ok+1;
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z 0-9]*$/",$password)) {
          $passwordErr = "Only letters, numbers and white space allowed";
          $ok = $ok-1;
        }
    }
  }

  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>



<div class="container">
  <h2 class="form-signin-heading text-center">Signing in Notes App by MAP Team</h2>

  <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">  
    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required="" autofocus="">
    
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
    
    <button class="btn btn-lg btn-success btn-block" type="submit" value="Login">Sign in</button>
    <a class="text-center" href="sign_up.php" title="Sign up">
      <p>Do not have account yet? Sign up here</p>
    </a>

<?php

  include "database.php";
  /*
  echo '<br/> <br/> <form class="reset" name="form_reset" method="post">
    <input type="submit" name="reset" value="Reset Database" onclick="resetDatabase()"/>
  </form>';

  if(isset($_POST['reset'])){
    $database = getConn();
    $sql = "DELETE FROM users";
    $result = $database->query($sql);

    $sql = "DELETE FROM tasks";
    $result = $database->query($sql);

    echo "Database reset ok!";

    $database->close();
  }
  */


  if(!($ok == 2)){
    // echo '<p>Error: Please check your field</p>';
    if ($usernameErr != "") {
      echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Username error: $usernameErr</p>";
    }
    if ($passwordErr != "") {
      //echo "<script type=\"text/javascript\">alert(\"Username error: $usernameErr  Password error: $passwordErr\");</script>";
      echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Password error: $passwordErr</p>";
    }
  } else {
    //verify if username and password is correct in database and if yes login, otherwise retry
    $result = verifyUser($username, $password);
    switch ($result) {
      case 1:
        //userverify
        $cookie_name = "user";
        $cookie_value = $username;
        $cookie_password = "password";
        setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
        setcookie($cookie_password, $password, time() + (86400), "/"); // 86400 = 1 day

        //echo "Hello " .$username."";
        //echo '<p> <a href="private.php">Enter</a> </p> ';
        header('Location: private.php');
        break;

      case 2:
        //echo "<script type=\"text/javascript\">alert(\"Wrong password.\");</script>";
        echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Wrong password.</p>";
        break;

      case 3:
        //echo "<script type=\"text/javascript\">alert(\"User not found.\");</script>";
        echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">User not found</p>";
        break;
      
      default:
        # code...
        break;
    }
  }
?>

</form>
</div>

<?php include_once "src/footer.php"; ?>
