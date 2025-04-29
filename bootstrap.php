<?php
// Bootstrap file for the freelance platform

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define base path
define("BASE_PATH", dirname(__DIR__));

// Include configuration files
require_once BASE_PATH . "/private/config/database.php";
// require_once BASE_PATH . "/private/config/constants.php"; // If you have constants
// require_once BASE_PATH . "/private/config/settings.php"; // If you have settings

// Include helper functions
require_once BASE_PATH . "/private/utils/Helpers.php";

// Autoload classes (if using OOP)
// spl_autoload_register(function ($class_name) {
//     $file = BASE_PATH . 
//             str_replace("\\", "/", $class_name) . ".php";
//     if (file_exists($file)) {
//         require_once $file;
//     }
// });

// Error reporting (adjust for production)
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Set default timezone
date_default_timezone_set("UTC");

// Check for remember me cookie
if (!is_logged_in() && isset($_COOKIE["remember_token"])) {
    $token = $_COOKIE["remember_token"];
    
    try {
        $db = getDbConnection();
        if ($db) {
            $stmt = $db->prepare("SELECT u.user_id, u.email, u.user_type, u.first_name, u.last_name 
                                 FROM users u 
                                 JOIN user_tokens ut ON u.user_id = ut.user_id 
                                 WHERE ut.token = :token AND ut.expiry > NOW() AND u.account_status = 'active'");
            $stmt->bindParam(":token", $token);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Log the user in
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["user_type"] = $user["user_type"];
                $_SESSION["user_name"] = $user["first_name"] . " " . $user["last_name"];
                $_SESSION["logged_in"] = true;
                
                // Update last login time
                $updateStmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE user_id = :user_id");
                $updateStmt->bindParam(":user_id", $user["user_id"]);
                $updateStmt->execute();
            } else {
                // Invalid or expired token, remove cookie
                setcookie("remember_token", "", time() - 3600, "/");
            }
        }
    } catch (PDOException $e) {
        error_log("Remember me error: " . $e->getMessage());
    }
}

// Include this bootstrap file at the beginning of your main PHP scripts (e.g., index.php, page scripts)
// Example: require_once __DIR__ . 

