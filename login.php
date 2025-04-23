<?php
session_start();
session_regenerate_id(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = trim(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $password = trim($_POST["password"]);

        if (!file_exists("logins.txt") || filesize("logins.txt") == 0) {
            header('Location: login.php?incorrect=true');
            exit();
        }

        $data = file_get_contents("logins.txt");
        $lines = explode("\n", trim($data));

        foreach ($lines as $line) {
            $tokens = explode(":", $line);
            if (count($tokens) !== 3) continue;

            if ($tokens[0] === $username && password_verify($password, $tokens[1])) {
                $_SESSION["username"] = $username;
                $_SESSION["authenticated"] = 'true';
                header('Location: index.php');
                exit();
            }
        }

        header('Location: login.php?incorrect=true');
        exit();
    } else {
        header('Location: login.php?incorrect=false');
        exit();
    }
} else {
    if (isset($_GET["incorrect"])) {
        $alerts = [
            "true" => "Incorrect Password",
            "exists" => "Create account failed because user already exists",
            "false" => "Create account was a success!"
        ];

        if (isset($alerts[$_GET["incorrect"]])) {
            echo "<script>alert('{$alerts[$_GET["incorrect"]]}');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Team 4 Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="page">
    <!-- [banner] -->
    <header id="banner">
        <hgroup>
            <h1>Login</h1>
        </hgroup>        
    </header>

    <!-- [content] -->
    <section id="content">
        <form id="login" method="post">
            <label for="username">Username:</label>
            <input id="username" name="username" type="text" required>
            <label for="password">Password:</label>
            <input id="password" name="password" type="password" required>                    
            <br /><br/>
            <input type="submit" value="Login">
        </form>
    </section>

    <br><hr><br>

    <header id="banner">
        <hgroup>
            <h1>Create Account</h1>
        </hgroup>        
    </header>

    <section id="content">
        <form id="create" method="post" action="./create.php">
            <label for="username">Username:</label>
            <input id="username" name="username" type="text" required>
            <label for="password">Password:</label>
            <input id="password" name="password" type="password" required>
            <br /><br/>
            <input type="submit" value="Create Account">
        </form>
    </section>
    <!-- [/content] -->
</div>
<!-- [/page] -->
</body>
</html>