<?php
  session_start();

  include "src/header.php";
  include "src/mainmenu.php";
 ?>

 <form action="action/login_action.php" method="post">
   <fieldset>
     <legend>Login</legend>
     <p><label for="username">Username: </label> <input type="text" name="username" id="username"/></p>
     <p><label for="username">Password: </label> <input type="text" name="password" id="password"/></p>
     <p class="center"><input value="Login" type="submit" class="center" /></p>
   </fieldset>
 </form>


<?php include "src/footer.php"; ?>
