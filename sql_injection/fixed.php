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

    // FIXED CODE: Using PDO Prepared Statements with Parameterized Queries
    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_role = htmlspecialchars($user['role']);
            $message = "<div class='message-success'>✅ FIX APPLIED: Logged in successfully as: " . htmlspecialchars($user['username']) . "! (Role: {$user_role})</div>";
        } else {
            $message = "<div class='message-block'>❌ Login failed. SQL Injection payload failed.</div>";
        }
    } catch (PDOException $e) {
        $message = "<div class='message-block'>Database Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fixed SQL Injection Login</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { color: #008000; text-align: center; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; margin-bottom: 15px;}
        button:hover { background-color: #218838; }
        .message-success { color: #155724; background-color: #d4edda; border: 2px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; font-size: 1.1em; }
        .message-block { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; }

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
        <h2>SQL Injection (Fixed with Prepared Statements)</h2>
        <p>Try the same payload (password: <code>' OR '1'='1' #</code>). It should fail.</p>
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