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

    	
<h1>sänkig skäpp</h1>	

<p>Klicka på ruta för att skjuta, öändligt med skott!!! om rutan är grå så har du missat, om rutan blir röd så har du träffat en båt.</p>
<p>Du har vunnit så här många gånger -</p>
<p>Du har förlorat så här många gånger -</p>

<div id="gameboard">
</div>

<script type="text/javascript" src="battleship.js"></script>

<form action="welcome.php" method="POST">
Username:<input type="text" name="name"><br>
<input type="submit">
</form>

<?php
$servername = "localhost";
$username = "ntigskov_websrv2-ak";
$password = "jAvjEErb}M8U";
$conn = new mysqli($servername, $username, $password);

mysqli_select_db($conn, "ntigskov_websrv2-ak");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$query = "SELECT * FROM score";
$result = mysqli_query($conn, $query);

echo '<h1>' . $hometitle . '</h1>';

// Database connection
$host = 'localhost';
$dbname = 'battleships';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle AJAX request
if (isset($_GET['action']) && $_GET['action'] === 'getLeaderboard') {
    $stmt = $pdo->query("SELECT name, score FROM players ORDER BY score DESC LIMIT 10");
    $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($leaderboard);
    exit;
}
?>
?>
    
</body>
</html>
