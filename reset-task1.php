<?php
	include "database.php";
	
	$database = getConn();
    $sql = "DELETE FROM users";
    $result = $database->query($sql);

    $sql = "DELETE FROM tasks";
    $result = $database->query($sql);

    echo "Database reset ok!";

    $database->close();
?>