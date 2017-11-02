<?php

$servername = "ktangdb.clb60p2aechx.us-east-2.rds.amazonaws.com";
$username = "publicuser";
$password = "password";
$dbname = "KtangDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Dante";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "MoveName: " . $row["MoveName"]. "Input: " . $row["Input"]. "Damage" . $row["Damage"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>