<?php
// Handle Logout
if (isset($_GET['logout'])) {
    header("Location: ../index.php");
    exit();
}

$search_query = '';
if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Reflected XSS</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; }
        h2 { color: #cc0000; text-align: center; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        input[type="text"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #dc3545; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; margin-bottom: 15px;}
        button:hover { background-color: #c82333; }
        .message-output { border: 1px solid #ff0000; padding: 10px; background-color: #ffebeb; border-radius: 5px; margin-bottom: 15px; }

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
        <h2>Reflected XSS (Vulnerable)</h2>
        <p>Access the URL with a malicious query: <code>?query=&lt;script&gt;alert('Reflected XSS');&lt;/script&gt;</code></p>
        
        <h3>Search Results</h3>
        <?php if ($search_query): ?>
            <div class="message-output">
                <p>You searched for: <strong><?= $search_query ?></strong></p> 
            </div>
        <?php endif; ?>
        
        <form method="get">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>

        <a href="?logout=true" class="logout-btn">Return to Index (Logout)</a>
    </div>
</body>
</html>