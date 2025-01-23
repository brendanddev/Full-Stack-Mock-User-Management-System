<?php require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Retrieve raw json POST data
    
    if (isset($data['email']) && isset($data['password']) && isset($data['name'])) {
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password'];
        $name = htmlspecialchars($data['name']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userExists) {
                echo json_encode(['success' => false, 'message' => 'A user already exists with that email!']);
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'The account was created successfully!']);
            exit;

        } else {
            echo json_encode(['success' => false, 'message' => 'The provided email is invalid.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'The required fields are missing.']);
        exit;
    }
}


?>