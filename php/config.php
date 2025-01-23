<?php 
$dsn = "mysql:dbname=login_system;host=127.0.0.1"; // Connection string
$username = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $username, $password);

} catch (PDOException $e) {
    echo "An error occurred while connecting to the database!";
}
?>