<?php
	include "database.php";

	$database = getConn();
    $sql = "DELETE FROM users;";
    $result = $database->query($sql);

    $sql = "DELETE FROM notes;";
    $result = $database->query($sql);

    $sql = "INSERT INTO users (email, username, password) VALUES ('john@example.com', 'John', 'Dodo');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('mary@example.com', 'Mary', 'Mary96');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('matteo@example.com', 'matteo', 'pippo');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('jusy@example.com', 'giu', 'giugiu21');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('vale87@example.com', 'vales', 'ValesVales');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('nicola@example.com', 'nik', 'c834cola');";
    $sql .= "INSERT INTO users (email, username, password) VALUES ('pino@example.com', 'pino', 'three32');";
    
    $sql .= "INSERT INTO notes (username, note) VALUES ('John', 'Nordea bank account: FI4132301423014301');";
    $sql .= "INSERT INTO notes (username, note) VALUES ('Mary', 'Metropolia acc: marimekko pwd: hihuhohe');";
    $sql .= "INSERT INTO notes (username, note) VALUES ('matteo', 'I am doing good at hacking.');";
    $sql .= "INSERT INTO notes (username, note) VALUES ('giu', 'Bank balance: 822 220$');";
    $sql .= "INSERT INTO notes (username, note) VALUES ('vales', 'I love you!');";
    $sql .= "INSERT INTO notes (username, note) VALUES ('nik', 'I don''t know what to do.');";
    $sql .= "INSERT INTO notes (username, note) VALUES ('pino', 'Toys is my life.');";
    $result = $database->query($sql);

    if ($database->multi_query($sql) === TRUE) {
    	echo "Database reset ok!";
    } else {
    	echo "Error: " . $sql . "<br>" . $database->error;
    }

    $database->close();
?>