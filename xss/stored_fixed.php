<?php
require_once('../db_config.php');

// Handle Logout
if (isset($_GET['logout'])) {
    header("Location: ../index.php");
    exit();
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = 'Guest'; 
    $content = $_POST['content'];

    // Inserting raw input is fine, but the fix is applied on OUTPUT!
    $sql = "INSERT INTO comments (author, content) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$author, $content]);
    $message = "<div class='message-success'>Comment posted. The output is now sanitized.</div>";
}

// Fetch comments
$comments = $pdo->query("SELECT * FROM comments ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fixed Stored XSS</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px; }
        h2 { color: #008000; text-align: center; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; margin-bottom: 15px;}
        button:hover { background-color: #218838; }
        .message-success { color: #155724; background-color: #d4edda; border: 2px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; font-size: 1.1em; }
        .comment { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background-color: #f9f9f9; border-radius: 5px; }

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
        <h2>Stored XSS (Fixed with htmlentities)</h2>
        <p>Try the same payload again. It should render the script tag as text.</p>
        
        <?= $message ?>
        
        <form method="post">
            <textarea name="content" rows="4" cols="50" placeholder="Enter comment..."></textarea><br>
            <button type="submit">Post Comment</button>
        </form>

        <h3>Recent Comments</h3>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <strong><?= htmlspecialchars($comment['author']) ?>:</strong>
                <p>
                    <?= htmlentities($comment['content']) ?> 
                </p>
            </div>
        <?php endforeach; ?>
        
        <a href="?logout=true" class="logout-btn">Return to Index (Logout)</a>
    </div>
</body>
</html>