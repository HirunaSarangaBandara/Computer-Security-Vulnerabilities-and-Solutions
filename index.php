<!DOCTYPE html>
<html>
<head>
    <title>IT3122 Computer Security ICA 3</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 900px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
        h2 { color: #007bff; }
        .vulnerability-section { margin-bottom: 30px; border: 1px solid #eee; padding: 15px; border-radius: 8px; }
        .links { list-style: none; padding: 0; }
        .links li { margin-bottom: 10px; }
        .links a { 
            display: inline-block; 
            padding: 8px 15px; 
            background-color: #f8f8f8; 
            border: 1px solid #ddd; 
            text-decoration: none; 
            color: #333; 
            border-radius: 5px; 
            margin-right: 10px;
        }
        .links a:hover { background-color: #e9e9e9; }
        .vulnerable { background-color: #ffcccc !important; color: #a00; border-color: #f00 !important; }
        .fixed { background-color: #ccffcc !important; color: #080; border-color: #0c0 !important; }
        .login-start { 
            background-color: #4CAF50 !important; 
            color: white !important; 
            border-color: #4CAF50 !important;
            font-size: 1.1em;
            padding: 12px 20px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>🔐 IT3122 Computer Security - In-course Assessment 3</h1>
        <p>This page demonstrate the three vulnerabilities and their implemented solutions.</p>
 
    <hr>
    
    <div class="vulnerability-section">
        <h2>1. SQL Injection 💉</h2>
        <p>Demonstration using PHP Data Objects (PDO). The solution uses Prepared Statements. (Click 'Return to Index' on the demo pages to return here.)</p>
        <ul class="links">
            <li>
                <a href="sql_injection/vulnerable.php" class="vulnerable">Vulnerable Code</a>
            </li>
            <li>
                <a href="sql_injection/fixed.php" class="fixed">Fixed Code</a>
            </li>
        </ul>
    </div>
    
    <hr>

    <div class="vulnerability-section">
        <h2>2. Cross-site Scripting (XSS) 📝</h2>
        <p>Demonstrating Stored, Reflected, and DOM-based XSS. The solution uses the <code>htmlentities</code> function for server-side output.</p>
        <ul class="links">
            <li>
                <strong>Stored XSS:</strong>
                <a href="xss/stored_vulnerable.php" class="vulnerable">Vulnerable</a>
                <a href="xss/stored_fixed.php" class="fixed">Fixed</a>
            </li>
            <li>
                <strong>Reflected XSS:</strong>
                <a href="xss/reflected_vulnerable.php" class="vulnerable">Vulnerable</a>
                <a href="xss/reflected_fixed.php" class="fixed">Fixed</a>
            </li>
            <li>
                <strong>DOM-based XSS:</strong>
                <a href="xss/dom_vulnerable.php" class="vulnerable">Vulnerable (Client-side)</a>
                <a href="xss/dom_fixed.php" class="fixed">Fixed (Client-side)</a>
            </li>
        </ul>
    </div>
    
    <hr>

    <div class="vulnerability-section">
        <h2>3. Cross-site Request Forgery (CSRF) 🍪</h2>
        <p>The **Synchronizer Token Pattern** is used for the solution. You must start here to create or manage the required session.</p>
        <ul class="links">
            <li>
                <a href="csrf/login.php" class="login-start">▶️ Start CSRF Demo Flow (Login/Manage Session)</a>
            </li>
        </ul>
    </div>

    <hr>
    
    <footer>
        <p>Note: All server-side code must be in PHP.</p>
    </footer>

</body>
</html>