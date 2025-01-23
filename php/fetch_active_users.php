<?php 
require 'config.php'; // Database configuration file

$role = 'User';
$status = 'Active';
$query = "SELECT name, email, role, profile_picture FROM users WHERE role = :role AND status = :status";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':status', $status);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users); // Returns the users as json

?>