<?php
  $username = $_POST['username'];
  $password = $_POST['password'];
  $salt = hash('md5', date("h:i:sa"));
  $passhash = $password;
  $myfile = fopen("logins.txt", "r");
  $data = "";
  if (filesize("logins.txt") != 0){
    $data = fread($myfile, filesize("logins.txt"));
  }
  fclose($myfile);
  $lines = explode("\n", $data);
  foreach($lines as $line){
    $tokens = explode(":", $line);
    if ($tokens[0] == $username){
      header("Location: login.php?incorrect=exists");
      exit();
    }
  }
  
  $myfile = fopen("logins.txt", "a");
  fwrite($myfile, $username . ":" . $passhash . ":" . $salt . "\n");
  fclose($myfile);
  header("Location: login.php?incorrect=false");
