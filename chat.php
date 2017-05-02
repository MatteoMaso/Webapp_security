<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang ="fr" lang="fr" >
    <head>
        <title>chat</title>
        <meta  http-equiv=" Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
<?php
if (isset($_POST['username']) AND isset($_POST['message'])) 
{
if ($_POST['username'] != NULL AND $_POST['message'] != NULL) 
{
// log in to MySQL	
mysql_connect("localhost", "root", "");
mysql_select_db("DATABASE");
//this code is used for protection.
$message = mysql_real_escape_string(htmlspecialchars($_POST['message']));
$username = mysql_real_escape_string(htmlspecialchars($_POST['username']));
// save to database (create a table, name is chat)
mysql_query("INSERT INTO chat VALUES('', '$username', '$message')");
// close database
mysql_close();
}
}
?>
<form action="chat.php" method= "post">
<p>
Username : <input type="text" name= "username" /><br>
Message : <input type="text" name= "message" /><br>
<input type="submit" value="Send">
</p>
</form>
<?php
//display newest content.
mysql_connect("localhost", "root", "");
mysql_select_db("DATABASE");
$source = mysql_query("SELECT * FROM chat ORDER BY ID DESC LIMIT 0,10");
mysql_close();
while ($data = mysql_fetch_array($source) )
{
?>
<p>
<strong><?php echo $data['username']; ?> </strong> : <?php echo $data['message']; ?>
</p>
<?php
}
?>
    </body>
</html>
