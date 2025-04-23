<?php
  session_start();
  $_SESSION["authenticated"] = "false";
  $_SESSION["username"] = "";
  header("Location: login.php");

