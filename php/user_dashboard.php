<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/index.html');
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'User';
$user_role = ucfirst($_SESSION['user_role'] ?? 'User'); 
$profile_pic = $_SESSION['profile_pic'] ?? 'default.png'; 

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login System - Home Page (Index)</title>
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
                <h1 class="header-title text-uppercase mb-3">Mock User Management System</h1>
                <p class="header-subtitle mb-4">Manage your users efficiently and securely</p>
            </header>

            <!-- Welcome User Card -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-light text-dark text-center">
                    <h5 class="card-title text-center mb-0">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h5>
                </div>
                <div class="card-body text-center">
                    <!-- Profile Image -->
                    <img src="../assets/<?php echo htmlspecialchars($profile_pic); ?>" 
                         alt="Profile Picture" 
                         class="rounded-circle mb-3" 
                         width="100" 
                         height="100" 
                         style="object-fit: cover;">
                    
                    <h5 class="card-title mt-2"><?php echo htmlspecialchars($user_name); ?></h5>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($user_role); ?></p>

                    <div class="d-grid gap-2">
                        <a href="edit_user_profile.php" class="btn btn-outline-primary">Edit Profile</a>
                        <a href="#" id="logout-btn" class="btn btn-danger">Logout</a>                    </div>
                </div>
            </div>

            <!-- User Details Section -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-light text-dark">
                    <h5 class="card-title text-center mb-0">User Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></li>
                        <li class="list-group-item"><strong>Role:</strong> <?php echo htmlspecialchars($user_role); ?></li>
                        <li class="list-group-item"><strong>Email:</strong> user@example.com</li>
                        <li class="list-group-item"><strong>Joined On:</strong> January 1, 2024</li>
                    </ul>
                </div>
            </div>

            <!-- Active Users Table -->
            <div class="card shadow-lg">
                    <div class="card-header bg-light text-dark">
                        <h5 class="card-title text-center mb-0">Active Users</h5>
                    </div>
                    <div class="card-body">
                        <!-- Empty Table -->
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
                        <button id="load-users-btn" class="btn btn-primary">See Active Users</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-4 mt-5">
            <div class="container">
                <div class="row">
                    <!-- Column 1: About Us -->
                    <div class="col-md-4">
                        <h5>About Us</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin ligula a ex tempor, et volutpat lorem tincidunt.</p>
                    </div>
        
                    <!-- Column 2: Quick Links -->
                    <div class="col-md-4 footer-links">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
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
        <script src="../js/user_dashboard.js"></script> <!-- JS File -->
    </body>
</html>