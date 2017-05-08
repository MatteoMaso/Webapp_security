<?php

  session_start();

  include "src/header.php";
  include "src/mainmenu.php";
  include "database.php"
 ?>

 <h1>WELCOME TO YOUR CHECK-LIST</h1>

 <p>
In this web site you can take note of all your task
 </p>

<?php
include "src/footer.php";

echo '<br/> <br/> <form class="init" name="form_init" method="post">
  <input type="submit" name="initUser" value="Initialize Users List Before start Haking" onclick="initUsers()"/>
</form>';

if(isset($_POST['initUser'])){
  $database = getConn();
  $sql = "INSERT INTO users (email, username, password) VALUES ('john@example.com', 'John', 'Dodo');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('mary@example.com', 'Mary', 'Mary96');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('matteo@example.com', 'matteo', 'pippo');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('jusy@example.com', 'giu', 'giugiu21');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('vale87@example.com', 'vales', 'ValesVales');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('nicola@example.com', 'nik', 'c834cola');";
  $sql .= "INSERT INTO users (email, username, password) VALUES ('pino@example.com', 'pino', 'three32');";

  $result = $database->query($sql);
  if ($database->multi_query($sql) === TRUE) {
    echo "Users list create correctly!";
  } else {
    echo "Error: " . $sql . "<br>" . $database->error;
  }
  $database->close();
}



?>
