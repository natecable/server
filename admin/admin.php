<?php
session_start();

// Ensure admin authentication
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== 'true' || $_SESSION["username"] !== "admin") {
    die("Not authenticated!");
}

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>(Team 4) Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Team 4</h1>

    <form id="delete" method="post" action="admin.php">
        <label for="delete_user">Delete the user:</label><br>
        <input type="text" id="delete_user" name="delete_user" required><br><br>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" id="submit" value="Submit">
    </form>

    <form id="clear" method="post" action="admin.php">
        <input hidden type="text" name="clear" value="true">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" id="submit" value="Clear All Messages">
    </form>
</body>
</html>

<?php
// Validate CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF verification failed.");
    }

    // Delete all messages securely
    if (isset($_POST["clear"]) && $_POST["clear"] === 'true') {
        if (file_exists("../messages.txt")) {
            file_put_contents("../messages.txt", "", LOCK_EX);
        }
    }

    // Delete a user safely (excluding admin)
    if (isset($_POST["delete_user"])) {
        $delete_user = trim(filter_var($_POST["delete_user"], FILTER_SANITIZE_STRING));

        if ($delete_user !== "admin" && file_exists("../logins.txt")) {
            $data = file_get_contents("../logins.txt");
            $lines = explode("\n", trim($data));
            $newdata = "";

            foreach ($lines as $line) {
                $tokens = explode(":", $line);
                if ($tokens[0] !== $delete_user) {
                    $newdata .= ($line . "\n");
                }
            }

            // Securely write new file contents with file locking
            $fp = fopen("../logins.txt", "w");
            if ($fp) {
                flock($fp, LOCK_EX);
                fwrite($fp, trim($newdata));
                flock($fp, LOCK_UN);
                fclose($fp);
            }
        }
    }
}
?>
