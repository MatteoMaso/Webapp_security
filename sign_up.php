<?php
  session_start();

  include "src/header.php";
  include "src/mainmenu.php";
 ?>

 <form action="action/sign_up_action.php" method="post">
   <fieldset>
     <legend>New user registration</legend>
     <p>
       <label for="email">Email:</label> <input type="email" name="email" id="email" />
       <br>
       <br>
       <label for="name">Full name:</label> <input type="text" name="name" id="name" />
       <br>
       <br>
       <label for="password">Password:</label> <input type="password" name="password" id="password" />
     </p>
     <p class="center"><input value="Register" type="submit" /></p>
   </fieldset>
 </form>


 <?php include "src/footer.php"; ?>
