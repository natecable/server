<?php
session_start();
// todo: change the default admin password in logins.txt
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == 'true' && $_SESSION["username"] == "admin") {
?>
    <html lang=en>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>(Insert Team Name) Room</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <h1>Insert Team Name Here!!</h1>
        <form id="delete" method="post" action="admin.php">
            <label for="message">Delete the user:</label><br>
            <input type="text" id="delete_user" name="delete_user"><br><br>
            <input type="submit" id="submit" value="Submit">
        </form>
        <form id="clear" method="post" action="admin.php">
            <input hidden type="text" id="clear" name="clear" value="true">
            <input type="submit" id="submit" value="Clear All Messages">
        </form>
    </body>

    </html>
<?php
} else {
    echo "Not authenticated!";
}

if (isset($_POST["clear"]) && $_POST["clear"] == 'true') {
    // delete all messages
    $myfile = fopen("../messages.txt", "w");
    fwrite($myfile, "");
    fclose($myfile);
}
if (isset($_POST["delete_user"]) && $_POST["delete_user"] != 'admin') {
    // delete the user if its not the admin
    $myfile = fopen("../logins.txt", "r");
    $data = "";
    if (filesize("../logins.txt") != 0) {
        $data = fread($myfile, filesize("../logins.txt"));
    }
    fclose($myfile);
    $lines = explode("\n", $data);
    $newdata = "";
    foreach ($lines as $line) {
        $tokens = explode(":", $line);
        if ($tokens[0] != $_POST["delete_user"]) {
            $newdata .= ($line . "\n");
        }
    }

    $myfile = fopen("../logins.txt", "w");
    fwrite($myfile, $newdata);
    fclose($myfile);
}
