<?php
session_start();
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $loginfound = 0;
        $myfile = fopen("logins.txt", "r");
        if (filesize("logins.txt") == 0){
            header('Location: login.php?incorrect=true');
        }
        $data = fread($myfile, filesize("logins.txt"));
        fclose($myfile);
        $lines = explode("\n", $data);
        foreach($lines as $line){
            $tokens = explode(":", $line);
            if (count($tokens) != 3){
                continue;
            }
            $passhash = $password;
            if ($tokens[0] == $username && $tokens[1] == $passhash){
                $loginfound = 1;
                $_SESSION["username"] = $username;
                $_SESSION["authenticated"] = 'true';
                header('Location: index.php');
            }
        }
	    if ($loginfound == 0){
        	header('Location: login.php?incorrect=true');
    	}
    } else {
        header('Location: login.php?incorrect=false');
    }
} else {
    if(isset($_GET["incorrect"])) {
        if ($_GET["incorrect"] == 'true'){
            echo '<script language="javascript">';
            echo 'alert("Incorrect Password")';
            echo '</script>';
        } elseif ($_GET["incorrect"] == "exists"){
            echo '<script language="javascript">';
            echo 'alert("Create account failed because user already exists")';
            echo '</script>';
        } elseif ($_GET["incorrect"] == "false"){
            echo '<script language="javascript">';
            echo 'alert("Create account was a success!")';
            echo '</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>(Insert Team Name) Room</title>
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
<?php } ?>
