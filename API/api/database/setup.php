<?php
require_once __DIR__ . '/../../config.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/appointments.sql');
    $db->exec($sql);
    
    echo "Database setup completed successfully!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 