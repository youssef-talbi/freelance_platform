<?php
// Process registration form submission

// Start session if not already started
session_start();

// Include database connection
require_once __DIR__ . '/../../private/config/database.php';
require_once __DIR__ . '/../../private/utils/Helpers.php';

// Initialize variables
$user_type = '';
$first_name = '';
$last_name = '';
$email = '';
$password = '';
$confirm_password = '';
$location = '';
$terms = false;
$error = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $user_type = isset($_POST['user_type']) ? trim($_POST['user_type']) : '';
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $terms = isset($_POST['terms']) ? true : false;
    
    // Validate form data
    if (empty($user_type) || empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || !$terms) {
        // Redirect back with error
        header('Location: /pages/auth/register.php?error=empty');
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: /pages/auth/register.php?error=invalid_email');
        exit;
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        header('Location: /pages/auth/register.php?error=password_mismatch');
        exit;
    }
    
    // Validate password strength (at least 8 characters)
    if (strlen($password) < 8) {
        header('Location: /pages/auth/register.php?error=weak_password');
        exit;
    }
    
    try {
        // Connect to database
        $db = new PDO("mysql:host={$db_config['host']};dbname={$db_config['dbname']}", $db_config['username'], $db_config['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if email already exists
        $stmt = $db->prepare("SELECT user_id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Email already exists
            header('Location: /pages/auth/register.php?error=email_exists');
            exit;
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Begin transaction
        $db->beginTransaction();
        
        // Insert user
        $stmt = $db->prepare("INSERT INTO users (email, password_hash, user_type, first_name, last_name, location, registration_date, account_status) 
                             VALUES (:email, :password_hash, :user_type, :first_name, :last_name, :location, NOW(), 'active')");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':location', $location);
        $stmt->execute();
        
        // Get the new user ID
        $user_id = $db->lastInsertId();
        
        // Create profile based on user type
        if ($user_type === 'freelancer') {
            $stmt = $db->prepare("INSERT INTO freelancer_profiles (user_id) VALUES (:user_id)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        } else if ($user_type === 'client') {
            $stmt = $db->prepare("INSERT INTO client_profiles (user_id) VALUES (:user_id)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }
        
        // Commit transaction
        $db->commit();
        
        // Registration successful, redirect to login page
        header('Location: /pages/auth/login.php?message=registered');
        exit;
        
    } catch (PDOException $e) {
        // Rollback transaction on error
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        
        // Log error for debugging
        error_log('Registration error: ' . $e->getMessage());
        
        // Redirect with generic error
        header('Location: /pages/auth/register.php?error=db_error');
        exit;
    }
}
