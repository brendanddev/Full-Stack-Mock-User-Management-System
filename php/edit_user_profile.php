<?php 
require 'config.php';
session_start();

$id = $_SESSION['user_id'];

$user_name = ''; // Default values to avoid undefined variable
$email = '';
$profilePic = '';

try {
    $query = "SELECT email, profile_picture, name FROM users WHERE id = :id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Assign values from the database if the user is found
        $user_name = $user['name'];
        $email = $user['email'];
        $profilePic = $user['profile_picture'] ?? 'default.png'; // Fallback to default picture

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['user_name']) && isset($_POST['user_email'])) {
                $newName = htmlspecialchars($_POST['user_name']);
                $newEmail = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];

                // Validate email
                if (filter_var($newEmail, FILTER_VALIDATE_EMAIL) === false) {
                    echo "Invalid email format!";
                    exit;
                }

                // Password change logic
                if ($newPassword && $confirmPassword) {
                    if ($newPassword !== $confirmPassword) {
                        echo "Passwords do not match!";
                        exit;
                    }

                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password = ? WHERE id = ?";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$hashedPassword, $id]);
                }

                // Handle profile picture upload
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
                    $fileName = $_FILES['profile_pic']['name'];
                    $fileTmpName = $_FILES['profile_pic']['tmp_name'];
                    $fileSize = $_FILES['profile_pic']['size'];
                    $fileError = $_FILES['profile_pic']['error'];
                    $fileType = $_FILES['profile_pic']['type'];

                    // Allowed file extensions
                    $allowed = array('jpg', 'jpeg', 'png');

                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize < 1000000) {
                                // Generate a unique name for the file
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = '../assets/' . $fileNameNew;

                                // Move the uploaded file to the assets directory
                                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                                    // Update the profile picture in the database
                                    $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
                                    $stmt = $dbh->prepare($query);
                                    $stmt->execute([$fileNameNew, $id]);

                                    // Update profile pic in session
                                    $_SESSION['profile_picture'] = $fileNameNew;
                                    $profilePic = $fileNameNew; // Update current profile pic
                                }
                            } else {
                                echo "Your file is too big!";
                            }
                        } else {
                            echo "There was an error uploading your file!";
                        }
                    } else {
                        echo "You can't upload files of this type!";
                    }
                }

                // Update user name and email in the database
                if ($newName !== $user_name || $newEmail !== $email) {
                    $query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute([$newName, $newEmail, $id]);
                    
                    // Update session data
                    $_SESSION['user_name'] = $newName;
                    $_SESSION['user_email'] = $newEmail;
                }

                // Redirect to user dashboard after saving changes
                header('Location: user_dashboard.php');
                exit;
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profile</h2>

        <!-- Edit Profile Form -->
        <form action="edit_user_profile.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user_name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                <img src="../assets/<?php echo htmlspecialchars($profilePic); ?>" alt="Current Profile Picture" width="100" height="100" class="mt-3 rounded-circle">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
