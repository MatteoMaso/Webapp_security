<?php
  session_start();
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
     <legend>New user registration</legend>
     <p>
       <label for="email">Email:</label> <input type="email" name="email" id="email" />
       <span class="error">* <?php echo $emailErr;?></span>
       <br><br>
       <label for="username">Full name:</label> <input type="text" name="username" id="username" />
       <span class="error">* <?php echo $usernameErr;?></span>
       <br><br>
       <label for="password">Password:</label> <input type="password" name="password" id="password" />
       <span class="error">* <?php echo $passwordErr;?></span>
     </p>
     <p class="center"><input value="Register" type="submit" /></p>
   </fieldset>
 </form>

 <?php

 // for checking
 echo "<h2>Your Input:</h2>";
 echo $username;
 echo "<br>";
 echo $email;
 echo "<br>";
 echo $password;
 echo "<br>";
 echo $ok;


 //if all the controll are ok, add user to database
 if(!($ok == 3)){
   echo '<p>Error: Please check your field</p>';
 } else { //field is correct
   //check is the username is available
   $control = checkUsername($username);
   if ($control == false) {
     include "src/header.php";
     echo '<p>Error: Please choose other Username</p>';
     echo '<p><a href="sign_up.php">Try again</p>';
     include "src/footer.php";
   } else {
     $control = addUser($email, $username, $password);
     echo $control;
     header('Location: private.php');
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

 <?php include_once "src/footer.php"; ?>
