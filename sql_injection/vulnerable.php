<?php
// Connect to the database
require_once('../db_config.php'); 

$message = '';
$user_role = '';

// Check for logout parameter
if (isset($_GET['logout'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // VULNERABLE CODE: Direct concatenation of user input into the SQL query
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    try {
        $stmt = $pdo->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_role = htmlspecialchars($user['role']);
            $message = "<div class='message-attack-success'>🚨 **VULNERABILITY EXPLOITED!** Logged in successfully as: " . htmlspecialchars($user['username']) . "! (Role: {$user_role})</div>";
        } else {
            $message = "<div class='message-error'>❌ Invalid credentials.</div>";
        }
    } catch (PDOException $e) {
        $message = "<div class='message-error'>Database Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable SQL Injection Login</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { color: #cc0000; text-align: center; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #dc3545; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; margin-bottom: 15px;}
        button:hover { background-color: #c82333; }
        .message-attack-success { color: #842029; background-color: #f8d7da; border: 2px solid #f5c6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; font-size: 1.1em; }
        .message-error { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        
        .logout-btn { 
            background-color: #6c757d; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 5px; 
            text-decoration: none; 
            font-size: 16px; 
            width: 100%; 
            display: block;
            box-sizing: border-box;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>SQL Injection (Vulnerable)</h2>
        <p>Try logging in as **admin** with the password payload: <code>' OR '1'='1' #</code></p>
        <?= $message ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required value="admin"><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <a href="?logout=true" class="logout-btn">Return to Index (Logout)</a>
    </div>
</body>
</html>