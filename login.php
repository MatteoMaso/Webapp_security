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
        if (!preg_match("/^[a-zA-Z ]*$/",$password)) {
          $passwordErr = "Only letters and white space allowed";
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

 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   <fieldset>
     <legend>Login</legend>
     <p><label for="username">Username: </label> <input type="text" name="username" id="username"/><span class="error">* <?php echo $usernameErr;?></span></p>
     <p><label for="username">Password: </label> <input type="text" name="password" id="password"/><span class="error">* <?php echo $passwordErr;?></span></p>
     <p class="center"><input value="Login" type="submit" class="center" /></p>
   </fieldset>
 </form>

<?php

  include "database.php";

  if(!($ok == 2)){
    echo '<p>Error: Please check your field</p>';
  } else {
    //verify if username and password is correct in database and if yes login, otherwise retry
  }

 ?>


<?php include_once "src/footer.php"; ?>
