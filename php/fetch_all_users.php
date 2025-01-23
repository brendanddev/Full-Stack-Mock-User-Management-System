<?php 
require 'config.php'; // Database configuration file

$query = "SELECT name, email, role, profile_picture FROM users";

$stmt = $dbh->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users); // Returns the users as json

?>
