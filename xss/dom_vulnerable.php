<?php
// Handle Logout
if (isset($_GET['logout'])) {
    header("Location: ../index.php");
    exit();
}
// NEW PAYLOAD (Obfuscated): <div onmouseover="eval('alert(\'Attack Happened\')')">MOVE YOUR MOUSE OVER ME</div>
// This uses 'eval' and 'onmouseover' to bypass common filters.
$payload = "%3Cdiv%20onmouseover%3D%22eval%28%27alert%28%5C%27Attack%20Happened%5C%27%29%27%29%22%3EATTACK%20TRIGGER%3C%2Fdiv%3E";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable DOM XSS</title>
    <style>
        /* ... (Styles remain the same) ... */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 550px; }
        h2 { color: #cc0000; text-align: center; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px; }
        .output-box { border: 1px solid #ff0000; padding: 15px; background-color: #ffebeb; border-radius: 5px; margin-bottom: 20px; }

        .test-link {
            background-color: #dc3545; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; 
            font-size: 16px; width: 100%; display: block; box-sizing: border-box; text-align: center; margin-bottom: 15px;
            cursor: pointer;
        }
        .back-btn { 
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
        <h2>DOM-based XSS (Vulnerable)</h2>
        <p><strong>Vulnerability Point:</strong> Unsafe use of <code>innerHTML</code> to write script data.</p>
        
        <p><strong>Steps:</strong> 1. Click the 'Load Payload'. 2. Click the 'Execute Payload'. 3. **Move mouse over the output box.**</p>

        <a href="#name=<?= $payload ?>" class="test-link">
            1. LOAD MALICIOUS PAYLOAD INTO URL (Click Once)
        </a>
        
        <div id="welcome_message" class="output-box">
            <p id="output_content">Waiting for data to be executed...</p>
        </div>
        
        <button id="executeBtn" class="test-link" style="background-color:#cc0000; margin-bottom: 15px;">
            2. EXECUTE PAYLOAD (Vulnerable)
        </button>

        <script>
            function executePayload() {
                const urlParams = new URLSearchParams(window.location.hash.substring(1));
                let name = urlParams.get('name');
                
                if (name) {
                    name = decodeURIComponent(name); 
                    
                    // VULNERABLE STEP: Using innerHTML executes injected HTML/scripts
                    // The payload is now part of the HTML output.
                    document.getElementById('output_content').innerHTML = "Hello User, " + name; 
                } else {
                    document.getElementById('output_content').innerHTML = "Click '1. LOAD MALICIOUS PAYLOAD' first."; 
                }
            }

            // Run on button click
            document.getElementById('executeBtn').onclick = executePayload;
            
            // Run immediately on page load to display initial state
            executePayload();
        </script>
        <a href="?logout=true" class="back-btn">Return to Index (Logout)</a>
    </div>
</body>
</html>