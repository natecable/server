<?php 
session_start();
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == 'true') {
?>
  <html lang=en>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8">
      <title>(Insert Team Name) Room</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <h1>Insert Team Name Here!!</h1>
    <form id="myForm" action="./post.php">
      <label for="message">Input Your Message:</label><br>
      <input type="text" id="message" name="message"><br><br>
      <input type="submit" id="submit" value="Submit">
    </form>
    <form id="logoutForm" action="logout.php">
      <input type="submit" id="submit" value="Logout">
    </form>
    <script>
    document.getElementById("myForm").onsubmit = function() {myFunction()};
  
    function myFunction() {
      alert("Messaged added to the chatsite!");
    }
    </script>
    <p>
      <?php 
        $myfile = fopen("messages.txt", "r");
        $data = "";
        if (filesize("messages.txt") != 0){
          $data = fread($myfile, filesize("messages.txt"));
        }
        $data = str_replace("\n", "<br>", $data);
        print($data);
        fclose($myfile);
      ?>
    </p>
    </body>
  </html>
<?php 
} else {
  header("Location: login.php");
}
?>