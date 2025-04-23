<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === 'true' && isset($_POST['message'])) {
    // Sanitize message input to prevent XSS
    $message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

    // Validate message length
    if (strlen($message) > 500) { // Limit message length
        header("Location: index.php?error=message_too_long");
        exit();
    }

    // Securely append message
    $file_data = $_SESSION["username"] . " ==> " . $message . "\n";
    if (file_exists('messages.txt')) {
        $file_data .= file_get_contents('messages.txt');
    }
    
    file_put_contents('messages.txt', $file_data, LOCK_EX); // Prevent race conditions

    header("Location: index.php?success=true");
} else {
    header('Location: login.php');
    exit();
}
?>
