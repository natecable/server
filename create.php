<?php
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if (empty($username) || empty($password)) {
      header("Location: login.php?incorrect=empty_fields");
      exit();
  }

  // Secure hashing
  $salt = bin2hex(random_bytes(16)); // Stronger salt generation
  $passhash = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing

  // Read existing logins securely
  $data = @file_get_contents("logins.txt");
  $lines = explode("\n", trim($data));

  foreach ($lines as $line) {
      $tokens = explode(":", $line);
      if ($tokens[0] === $username) {
          header("Location: login.php?incorrect=exists");
          exit();
      }
  }

  // Append new user safely
  file_put_contents("logins.txt", "$username:$passhash:$salt\n", FILE_APPEND | LOCK_EX);

  header("Location: login.php?incorrect=false");
?>
