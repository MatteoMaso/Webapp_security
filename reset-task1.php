<?php
	include "database.php";

	$database = getConn();
    $sql = "DELETE FROM users";
    $result = $database->query($sql);

    $sql = "DELETE FROM tasks";
    $result = $database->query($sql);

    $sql = "INSERT INTO users (email, username, password) VALUES ('john@example.com', 'John', 'Dodo');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('mary@example.com', 'Mary', 'Mary96');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('matteo@example.com', 'matteo', 'pippo');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('jusy@example.com', 'giu', 'giugiu21');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('vale87@example.com', 'vales', 'ValesVales');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('nicola@example.com', 'nik', 'c834cola');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('pino@example.com', 'pino', 'three32');";
    $result = $database->query($sql);

    if ($database->multi_query($sql) === TRUE) {
    	echo "Database reset ok!";
    } else {
    	echo "Error: " . $sql . "<br>" . $database->error;
    }

    $database->close();
?>