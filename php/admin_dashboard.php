<?php 
session_start(); // Start the session

if (!isset($_SESSION['user_id'])) { // Check if the user is logged in
    header('Location: ../html/index.html');
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'Admin'; // Store name of the user
$user_role = ucfirst($_SESSION['user_role'] ?? 'Admin'); // Store the user's role
$profile_pic = $_SESSION['profile_pic'] ?? 'default.png'; // Store the user's profile picture
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Poppins Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
        <!-- CSS File -->
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <div class="container mt-5">
            <header class="mb-5 text-center">
                <h1 class="header-title text-uppercase mb-3">Admin Dashboard</h1>
                <p class="header-subtitle mb-4">Manage users efficiently and securely</p>
            </header>

            <!-- Admin Card -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-light text-dark text-center">
                    <h5 class="card-title text-center mb-0">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h5>
                </div>
                <div class="card-body text-center">
                    <img src="../assets/<?php echo htmlspecialchars($profile_pic); ?>" 
                         alt="Profile Picture" 
                         class="rounded-circle mb-3" 
                         width="100" 
                         height="100" 
                         style="object-fit: cover;">
                    
                    <h5 class="card-title mt-2"><?php echo htmlspecialchars($user_name); ?></h5>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($user_role); ?></p>

                    <div class="d-grid gap-2">
                        <a href="edit_profile.php" class="btn btn-outline-primary">Edit Profile</a>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>

            <!-- Admin Controls Section -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-light text-dark text-center">
                    <h5 class="card-title text-center mb-0">Admin Controls</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button id="display-users-btn" class="btn btn-primary">Display Users</button>
                        <button id="edit-users-btn" class="btn btn-warning">Edit Users</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Table -->
        <div class="card shadow-lg">
            <div class="card-header bg-light text-dark">
                <h5 class="card-title text-center mb-0">Active Users</h5>
            </div>
            <div class="card-body">
                <!-- Users Table -->
                <table class="table table-bordered" id="active-users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Profile Picture</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty Rows Initially -->
                    </tbody>
                </table>
                <button id="display-users-btn" class="btn btn-primary">Display Users</button>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-4 mt-5">
            <div class="container">
                <div class="row">
                    <!-- Column 1: About Us -->
                    <div class="col-md-4">
                        <h5>About Us</h5>
                        <p>
                            I am a full-time Software Development and Engineering student passionate about coding and problem-solving. 
                            Currently seeking a full-time co-op or internship opportunity, I am eager to apply my skills and gain real-world experience. 
                            My goal is to become a Full Stack Developer, with expertise in both front-end and back-end technologies, and I am committed to 
                            creating innovative and efficient solutions.
                        </p>
                    </div>
        
                    <!-- Column 2: Quick Links -->
                    <div class="col-md-4 footer-links">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Home</a></li>
                        </ul>
                    </div>
        
                    <!-- Column 3: Contact -->
                    <div class="col-md-4">
                        <h5>Contact</h5>
                        <p>Email: <a href="mailto:dileob23@gmail.com" class="text-decoration-none">example@example.com</a></p>
                        <p>Phone: +1 (234) 567-890</p>
                    </div>
                </div>
        
                <div class="text-center mt-3">
                    <p>&copy; 2024 Brendan Dileo.</p>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
        <script src="../js/admin_dashboard.js"></script> <!-- New JS File -->
    </body>
</html>


