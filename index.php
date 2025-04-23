<?php
session_start();
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== 'true') {
    header("Location: login.php");
    exit();
}

// Read messages securely
$data = "";
if (file_exists("messages.txt") && filesize("messages.txt") > 0) {
    $data = file_get_contents("messages.txt");
}
$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
?>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>(Insert Team Name) Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Team 4</h1>

    <form id="myForm" action="./post.php" method="POST">
        <label for="message">Input Your Message:</label><br>
        <input type="text" id="message" name="message" required><br><br>
        <input type="submit" id="submit" value="Submit">
    </form>

    <form id="logoutForm" action="logout.php">
        <input type="submit" id="submit" value="Logout">
    </form>

    <script>
        document.getElementById("myForm").onsubmit = function() { alert("Message added to the chatsite!"); };
    </script>

    <p><?php echo $data; ?></p>
</body>
</html>

