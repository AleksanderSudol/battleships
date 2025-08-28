<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">                       
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
<div id="leaderboard">
</div>

<script type="text/javascript" src="battleship.js"></script>

<form action="" method="POST">
    Username:<input type="text" name="name" required><br>
    <input type="submit" value="Skicka Poang">
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

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // check if the username exists in the database
    $checkQuery = $conn->prepare("SELECT * FROM Ledarbrada WHERE Anvandarnamn = ?");
    $checkQuery->bind_param("s", $name);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if (mysqli_num_rows($checkResult) > 0) {
        // if the username exists, increment the score
        $updateQuery = $conn->prepare("UPDATE Ledarbrada SET Poang = Poang + 1 WHERE Anvandarnamn = ?");
        $updateQuery->bind_param("s", $name);
        $updateQuery->execute();
        $updQueryResult = $updateQuery->get_result();

        if ($updQueryResult) {
            echo "<p>Score updated successfully for $name!</p>";
        } else {
            echo "<p>Error updating score: " . mysqli_error($conn) . "</p>";
        }
    } else {
        // if the username does not exist, insert a new record with 1 point
        $insertQuery = $conn->prepare("INSERT INTO Ledarbrada (Anvandarnamn, Poang) VALUES (?, 1)");
        $insertQuery->bind_param("s", $name);
        $insertQuery->execute();
        $insQueryResult = $insertQuery->get_result();

        if ($insQueryResult) {
            echo "<p>New user $name added with 1 point!</p>";
        } else {
            echo "<p>Error adding user: " . mysqli_error($conn) . "</p>";
        }    
    }

    // close retard statements
    $checkQuery->close();
    if (isset($updateQuery)) $updateQuery->close();
    if (isset($insertQuery)) $insertQuery->close();
}

echo "Connected successfully";

$query = "SELECT * FROM Ledarbrada";
$result = mysqli_query($conn, $query);

// Handle AJAX request
if (isset($_GET['action']) && $_GET['action'] === 'getLeaderboard') {
    $query = "SELECT Anvandarnamn, Poang FROM Ledarbrada ORDER BY Poang DESC LIMIT 10";
    $result = mysqli_query($conn, $query);

    echo json_encode($result);
    exit;
}

$conn->close();
?>
    
</body>
</html>
