<?php
session_start();

// --- 1. LOGOUT LOGIC ---
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    $_SESSION = array(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy(); 
    // Redirect to the main index.php
    header("Location: ../index.php"); 
    exit();
}

// --- 2. LOGIN LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulate successful login
    $_SESSION['user_id'] = 101; 
    $_SESSION['username'] = 'TestUser';
    header("Location: login.php"); 
    exit();
}

$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSRF Demo Login/Logout</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; text-align: center; }
        h2 { color: #007bff; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        .info { margin-bottom: 20px; padding: 10px; background-color: #e9f7ff; border: 1px solid #bce8f1; border-radius: 5px; }
        
        /* Shared Button Styles for consistency */
        button, .logout-link, .demo-links a {
            padding: 10px 15px; 
            border-radius: 5px; 
            font-size: 16px; 
            width: 100%; 
            display: block; 
            box-sizing: border-box; /* Ensure padding is included in the width */
            text-decoration: none; 
            cursor: pointer;
            text-align: center;
        }

        .demo-links a { 
            margin-bottom: 10px; 
            font-weight: bold;
        }
        .vulnerable-link { background-color: #dc3545; color: white; border: 1px solid #c82333; }
        .fixed-link { background-color: #28a745; color: white; border: 1px solid #218838; }
        
        /* Login Button */
        button { background-color: #007bff; color: white; border: none; }
        button:hover { background-color: #0056b3; }

        /* Logout Link */
        .logout-link { 
            background-color: #6c757d; 
            color: white; 
            border: none;
            margin-top: 15px; 
        }
        .logout-link:hover { background-color: #5a6268; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($is_logged_in): ?>
            <h2>👋 Welcome Back, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
            <div class="info">
                Your session is active. Choose a demo to proceed.
            </div>
            
            <div class="demo-links">
                <a href="vulnerable.php" class="vulnerable-link">Run Vulnerable Demo</a>
                <a href="fixed.php" class="fixed-link">Run Fixed Demo (Recommended)</a>
            </div>

            <a href="?logout=true" class="logout-link">Logout</a>
        <?php else: ?>
            <h2>🔑 CSRF Demo Login</h2>
            <p>Click login to establish a session required for the demos.</p>
            <form method="post">
                <button type="submit">Login (Simulated)</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>