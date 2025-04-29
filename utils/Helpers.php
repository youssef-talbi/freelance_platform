<?php
// Helper functions for the freelance platform

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Get current user ID
function get_current_user_id() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
}

// Get user type (client or freelancer)
function get_user_type() {
    return isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';
}

// Get user name
function get_user_name() {
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
}

// Format currency
function format_currency($amount, $currency = '$') {
    return $currency . number_format($amount, 2);
}

// Format date
function format_date($date, $format = 'M j, Y') {
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

// Calculate time ago
function time_ago($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return 'just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 2592000) {
        $weeks = floor($diff / 604800);
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 31536000) {
        $months = floor($diff / 2592000);
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        $years = floor($diff / 31536000);
        return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
    }
}

// Sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Generate random string
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Redirect with message
function redirect($url, $message = '', $message_type = 'info') {
    if (!empty($message)) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $message_type;
    }
    header("Location: $url");
    exit;
}

// Display message
function display_message() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
        
        echo '<div class="alert alert-' . $message_type . '" data-dismissible data-auto-dismiss>';
        echo '<div class="alert-icon">' . ($message_type === 'success' ? '✓' : '!') . '</div>';
        echo '<div>' . $message . '</div>';
        echo '</div>';
        
        // Clear the message
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}

// Truncate text
function truncate_text($text, $length = 100, $append = '...') {
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . $append;
    }
    return $text;
}

// Check if user has permission
function has_permission($permission) {
    // This is a simple implementation, can be expanded based on roles
    if (!is_logged_in()) {
        return false;
    }
    
    $user_type = get_user_type();
    
    switch ($permission) {
        case 'create_project':
            return $user_type === 'client';
        case 'submit_proposal':
            return $user_type === 'freelancer';
        case 'view_dashboard':
            return true; // Both client and freelancer can view their dashboards
        default:
            return false;
    }
}

// Upload file
function upload_file($file, $destination_folder, $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']) {
    // Check if file was uploaded without errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'success' => false,
            'error' => 'Upload failed with error code: ' . $file['error']
        ];
    }
    
    // Check file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        return [
            'success' => false,
            'error' => 'File size exceeds the limit of 5MB'
        ];
    }
    
    // Get file extension
    $file_info = pathinfo($file['name']);
    $extension = strtolower($file_info['extension']);
    
    // Check if file type is allowed
    if (!in_array($extension, $allowed_types)) {
        return [
            'success' => false,
            'error' => 'File type not allowed. Allowed types: ' . implode(', ', $allowed_types)
        ];
    }
    
    // Create a unique filename
    $new_filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = $destination_folder . '/' . $new_filename;
    
    // Move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return [
            'success' => true,
            'filename' => $new_filename,
            'path' => $destination
        ];
    } else {
        return [
            'success' => false,
            'error' => 'Failed to move uploaded file'
        ];
    }
}

// Get file icon based on extension
function get_file_icon($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    switch ($extension) {
        case 'pdf':
            return 'pdf-icon';
        case 'doc':
        case 'docx':
            return 'word-icon';
        case 'xls':
        case 'xlsx':
            return 'excel-icon';
        case 'ppt':
        case 'pptx':
            return 'powerpoint-icon';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'image-icon';
        case 'zip':
        case 'rar':
            return 'archive-icon';
        default:
            return 'file-icon';
    }
}

// Validate form token (CSRF protection)
function validate_form_token($token_name) {
    if (!isset($_SESSION[$token_name]) || !isset($_POST['token'])) {
        return false;
    }
    
    if ($_SESSION[$token_name] !== $_POST['token']) {
        return false;
    }
    
    // Token is valid, remove it from session
    unset($_SESSION[$token_name]);
    
    return true;
}

// Generate form token
function generate_form_token($token_name) {
    $token = bin2hex(random_bytes(32));
    $_SESSION[$token_name] = $token;
    return $token;
}
