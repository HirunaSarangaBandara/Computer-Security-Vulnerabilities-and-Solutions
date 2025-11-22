<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = $_SESSION['transfer_result'] ?? "<div style='color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;'>Perform a transfer below, or click the attacker's button.</div>";
unset($_SESSION['transfer_result']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable CSRF</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; }
        h2 { color: #cc0000; text-align: center; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; }
        button:hover { background-color: #218838; }
        
        .user-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;}
        .logout-btn { 
            background-color: #6c757d; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 5px; 
            text-decoration: none; 
            font-size: 16px; 
            width: auto; 
            box-sizing: border-box; 
            text-align: center;
        }

        .attack-box { border: 2px solid #ff0000; padding: 15px; background-color: #ffebeb; border-radius: 5px; margin-top: 20px; text-align: center; }
        .attack-box h3 { color: #ff0000; margin-top: 0;}
        .attack-button { background-color: #cc0000; color: white; margin-top: 10px; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 80%; }
        
        /* Attack Message Styles */
        .message-attack-success { color: #842029; background-color: #f8d7da; border: 2px solid #f5c6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; font-size: 1.1em; }
    </style>
</head>
<body>
    <div class="container">
        <h2>💸 CSRF (Vulnerable Code)</h2>
        
        <div class="user-info">
            <p>Logged in as **<?= htmlspecialchars($_SESSION['username']) ?>**.</p>
            <a href="login.php?logout=true" class="logout-btn">Logout</a>
        </div>
        
        <?= $message ?>
        
        <h3>Legitimate Bank Transfer Form (Vulnerable)</h3>
        <form method="post" action="transfer.php">
            <label for="recipient">Recipient Account:</label>
            <input type="text" id="recipient" name="recipient" required value="Legitimate Account"><br>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required value="100" min="1"><br>
            <button type="submit">Transfer Money (Legitimate)</button>
        </form>

        <hr style="border-top: 1px dashed #ccc; margin: 30px 0;">

        <div class="attack-box">
            <h3>Simulated Attack Execution</h3>
            <p>This button simulates the user being tricked into clicking a button on *EvilSite.com*.</p>
            
            <form method="POST" action="transfer.php">
                <input type="hidden" name="recipient" value="AttackerAccount999">
                <input type="hidden" name="amount" value="999999">
                <button type="submit" class="attack-button">
                    CLICK TO RUN VULNERABLE ATTACK
                </button>
            </form>
            
            <p style="color: #ff4d4d; font-weight: bold; margin-top: 15px;">
                Expected Result: The transfer of $999,999 is successful, displaying the "ATTACK HAPPENED" message.
            </p>
        </div>
    </div>
</body>
</html>