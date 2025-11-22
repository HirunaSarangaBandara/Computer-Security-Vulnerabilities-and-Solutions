<?php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'security_demo');
define('DB_USER', 'root');
define('DB_PASS', '');

// Attempt to connect to MySQL using PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: Create a 'users' table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'user'
        );
        CREATE TABLE IF NOT EXISTS comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            author VARCHAR(50) NOT NULL,
            content TEXT NOT NULL
        );
    ");
    // Insert a test user for SQLi demo (password is 'admin')
    // Use password_hash() in a real application!
    $pdo->exec("
        INSERT IGNORE INTO users (username, password, role) 
        VALUES ('admin', 'admin', 'administrator');
    ");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>