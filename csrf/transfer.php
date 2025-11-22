<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Must be logged in to perform action.");
}

// FIX: Check for the marker sent by the malicious form on the fixed page, OR check for the token itself.
$is_fixed_context = isset($_POST['csrf_token']) || isset($_POST['fixed_page_marker']);

$is_vulnerable_request = !isset($_POST['csrf_token']);
// FIX: Set target page based on the marker/token presence
$target_page = $is_fixed_context ? 'fixed.php' : 'vulnerable.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'] ?? '0';
    $recipient = $_POST['recipient'] ?? 'Unknown';

    // --- CSRF TOKEN CHECK ---
    $token_check_passed = true;

    // Check validation only if we are in the fixed context
    if ($is_fixed_context) {
        // If the request didn't submit a token (attack form), it MUST fail the check
        if ($is_vulnerable_request) { 
            $token_check_passed = false;
        } 
        // If the request submitted a token (legitimate form), validate it
        elseif (empty($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $token_check_passed = false;
        }
        
        // Invalidate the token only if a legitimate one was used (not needed on attack fail path, but good practice)
        if (isset($_POST['csrf_token'])) {
            unset($_SESSION['csrf_token']);
        }
    }
    
    // Define styles
    $error_style = "color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;";
    $success_style = "color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;";
    $attack_style = "color: #842029; background-color: #f8d7da; border: 2px solid #f5c6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; font-size: 1.1em;";


    if (!$token_check_passed) {
        // Attack attempt from fixed.php failed
        $_SESSION['transfer_result'] = "<div style='{$error_style}'>🚫 **ATTACK STOPPED!** 🔒 Security check failed. The malicious transfer of **$" . htmlspecialchars($amount) . "** to **" . htmlspecialchars($recipient) . "** was blocked.</div>";
    } else {
        // Transfer succeeded (Legitimate or Vulnerable)
        
        if ($is_vulnerable_request) {
            // Attack on VULNERABLE page succeeded
            $_SESSION['transfer_result'] = "<div style='{$attack_style}'>🚨 **ATTACK HAPPENED!** The vulnerable site failed to check for a token. Transfer of **$" . htmlspecialchars($amount) . "** to **" . htmlspecialchars($recipient) . "** was successful!</div>";
        } else {
            // Legitimate transfer on fixed page succeeded
            $result_message = "<div style='{$success_style}'>✅ **SUCCESS**: Legitimate transfer of **$" . htmlspecialchars($amount) . "** to **" . htmlspecialchars($recipient) . "** completed.</div>";
            $_SESSION['transfer_result'] = $result_message;
        }
    }

    header("Location: " . $target_page);
    exit();
}
?>