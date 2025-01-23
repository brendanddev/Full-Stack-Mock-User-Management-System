<?php 
// Logout Script

session_start(); // Start the session

session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: ../html/index.html'); // Redirect to home/login page
exit;

?>