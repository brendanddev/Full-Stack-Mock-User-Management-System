<?php 
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Retrieve raw json POST data

    if (isset($data['email']) && isset($data['password'])) {

    
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {

            $query = "SELECT id, name, password_hash, role, status, profile_picture FROM users WHERE email = :email";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_status'] = $user['status'];
                    $_SESSION['profile_pic'] = $user['profile_picture'];

                    $redirect = "";
                    if ($user['role'] == 'User') {
                        $redirect = '../php/user_dashboard.php';
                    } elseif ($user['role'] == 'Admin') {
                        $redirect = '../php/admin_dashboard.php';
                    }

                    echo json_encode([
                        'success' => true, 
                        'message' => 'Login successful!', 
                        'redirect' => $redirect,        
                        'role' => $user['role']            
                    ]);                
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No user found with that email address.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'The provided email is invalid!']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'The required fields are missing.']);
        exit;
    }
}


?>