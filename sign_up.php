<?php
  include "src/header.php";
  include "src/mainmenu.php";
  include "database.php";
 $emailErr =  $usernameErr =  $passwordErr = "";
 $email =  $username =  $password = "";
 $ok = 0;
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
   if (empty($_POST["email"])) {
       $emailErr = "Email is required";
   } else {
       $email = test_input($_POST["email"]);
       $ok = $ok+1;
       // check if e-mail address is well-formed
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $emailErr = "Invalid email format";
         $ok = $ok-1;
       }
   }
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
  <h2 class="form-signin-heading text-center">New user registration</h2>

  <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">  
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required="" autofocus="">

    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required="" autofocus="">
    
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
    
    <button class="btn btn-lg btn-primary btn-block" type="submit" value="Register">Register</button>
    <a class="text-center" href="login.php" title="Login">
      <p>Already had an account? Log in here</p>
    </a>

 <?php
 //if all the controll are ok, add user to database
 if(!($ok == 3)){
    if ($emailErr != "") {
      echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Email error: $emailErr</p>";
    }
    if ($usernameErr != "") {
      echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Username error: $usernameErr</p>";
    }
    if ($passwordErr != "") {
      //echo "<script type=\"text/javascript\">alert(\"Username error: $usernameErr  Password error: $passwordErr\");</script>";
      echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Password error: $passwordErr</p>";
    }
   //echo '<p>Error: Please check your field</p>';
 } else { //field is correct
   //check is the username is available
   $control = checkUsername($username);
   if ($control == false) {
     include "src/header.php";
     echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Username already taken.<br>Please use another one.</p>";
     //echo '<p><a href="sign_up.php">Try again</p>';
   } else {
     $control = addUser($email, $username, $password);
     echo "<p class=\"text-center\" style=\"color: #ff7f7f;\">Registration success. Please go to login page to start your experience.</p>";
     header('Location: login.php');
   }
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

 </form>
</div>

 <?php include_once "src/footer.php"; ?>
