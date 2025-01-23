<?php 
$dsn = "mysql:dbname=system;host="; // Connection string
$username = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $username, $password);

} catch (PDOException $e) {
    echo "An error occurred while connecting to the database!";
}
?>
