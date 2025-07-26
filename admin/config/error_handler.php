<?php
// Error handling configuration for admin panel

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to users
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " Error: [$errno] $errstr in $errfile on line $errline\n";
    error_log($error_message, 3, __DIR__ . '/../logs/error.log');
    
    // For critical errors, you might want to send an email or notification
    if ($errno == E_ERROR || $errno == E_PARSE || $errno == E_CORE_ERROR) {
        // Log critical error
        error_log("CRITICAL ERROR: " . $error_message, 3, __DIR__ . '/../logs/critical.log');
    }
    
    return true; // Don't execute PHP internal error handler
}

// Set custom error handler
set_error_handler("customErrorHandler");

// Exception handler
function customExceptionHandler($exception) {
    $error_message = date('Y-m-d H:i:s') . " Exception: " . $exception->getMessage() . 
                    " in " . $exception->getFile() . " on line " . $exception->getLine() . "\n";
    error_log($error_message, 3, __DIR__ . '/../logs/error.log');
    
    // For database connection errors, show user-friendly message
    if ($exception instanceof PDOException) {
        // Log the actual error
        error_log("Database Error: " . $exception->getMessage(), 3, __DIR__ . '/../logs/db_error.log');
        
        // Show user-friendly message
        echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;">
                <strong>Database Connection Error:</strong> Unable to connect to the database. Please try again later or contact the administrator.
              </div>';
    } else {
        // For other exceptions, show generic error message
        echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;">
                <strong>System Error:</strong> An unexpected error occurred. Please try again later.
              </div>';
    }
}

// Set exception handler
set_exception_handler("customExceptionHandler");

// Function to safely display database errors
function handleDatabaseError($error, $context = '') {
    $error_message = date('Y-m-d H:i:s') . " Database Error in $context: " . $error . "\n";
    error_log($error_message, 3, __DIR__ . '/../logs/db_error.log');
    
    // Return user-friendly error message
    return "Unable to load data. Please try again later.";
}

// Function to validate database connection
function validateDatabaseConnection($db) {
    try {
        $db->query('SELECT 1');
        return true;
    } catch (PDOException $e) {
        handleDatabaseError($e->getMessage(), 'Connection Validation');
        return false;
    }
}

// Create logs directory if it doesn't exist
$logs_dir = __DIR__ . '/../logs';
if (!is_dir($logs_dir)) {
    mkdir($logs_dir, 0755, true);
}

// Function to log admin actions (optional)
function logAdminAction($action, $details = '') {
    $log_message = date('Y-m-d H:i:s') . " Admin Action: $action - $details\n";
    error_log($log_message, 3, __DIR__ . '/../logs/admin_actions.log');
}

// Function to sanitize output
function sanitizeOutput($data) {
    if (is_array($data)) {
        return array_map('sanitizeOutput', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Function to format date/time for display
function formatDateTime($datetime, $format = 'g:i A') {
    try {
        return date($format, strtotime($datetime));
    } catch (Exception $e) {
        return 'Invalid Date';
    }
}

// Function to format date for display
function formatDate($date, $format = 'm/d/y') {
    try {
        return date($format, strtotime($date));
    } catch (Exception $e) {
        return 'Invalid Date';
    }
}
?> 