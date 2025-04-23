<?php
session_start();
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == 'true' && isset($_GET['message'])) {
  print($_SESSION["authenticated"]);
  echo "<h1>AUTH</h1>";
  $file_data = $_SESSION["username"] . " ==> " . $_GET['message'] . "\n";
  $file_data .= file_get_contents('messages.txt');
  file_put_contents('messages.txt', $file_data);
  header("Location: index.php");
} else {
  print($_SESSION["authenticated"]);
  header('Location: login.php');
}
