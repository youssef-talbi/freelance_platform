<?php
// Include configuration and helper functions
// require_once __DIR__ . 

// Placeholder for session start and user check
function is_logged_in() { return false; } // Replace with actual session check
function get_user_type() { return 'client'; } // Replace with actual user type retrieval
function get_current_user_id() { return 1; } // Replace with actual user ID retrieval

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelance Hub - Find & Hire Freelancers</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <!-- Font Awesome for Icons (Optional, but useful for social links etc.) -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="/">
                        <img src="/assets/images/freelancer_logo.png" alt="Freelance Hub Logo">
                        Freelance Hub
                    </a>
                </div>
                <ul class="nav-links">
                    <li><a href="../pages/projects/list.php">Browse Projects</a></li>
                    <li><a href="../pages/projects/create.php">Post a Project</a></li>
                    <?php if (is_logged_in()): ?>
                        <li><a href="/pages/dashboard/<?php echo get_user_type(); ?>-dashboard.php">Dashboard</a></li>
                        <li><a href="../pages/profile/view.php?id=<?php echo get_current_user_id(); ?>">Profile</a></li>
                        <li><a href="../pages/auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="../pages/auth/login.php">Login</a></li>
                        <li><a href="../pages/auth/register.php" class="btn btn-sm">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </nav>
        </div>
    </header>
    <main>

