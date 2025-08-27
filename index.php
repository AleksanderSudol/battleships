<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <h1>Choose gamemode</h1>
    </nav>
<?php
$servername = "localhost";
$username = "ntigskov_websrv2-ak";
$password = "jAvjEErb}M8U";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
    
</body>
</html>
