<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "ktangdb.clb60p2aechx.us-east-2.rds.amazonaws.com";
$username = "publicuser";
$password = "password";
$dbname = "KtangDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
$character = $_GET['characterValue'];
$sql = "SELECT * FROM " . $character . ";";
$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"MoveName":"' . $rs["MoveName"] . '",';
    $outp .= '"Input":"' . $rs["Input"] . '",';
	$outp .= '"Damage":"' . $rs["Damage"] . '",';
	$outp .= '"Startup":"' . $rs["Startup"] . '",';
	$outp .= '"Active":"' . $rs["Active"] . '",';
	$outp .= '"Recovery":"' . $rs["Recovery"] . '",';
	$outp .= '"Total":"' . $rs["Total"] . '",';
	$outp .= '"BlockAdvantage":"' . $rs["BlockAdvantage"] . '",';
	$outp .= '"HitAdvantage":"' . $rs["HitAdvantage"] . '",';
    $outp .= '"CounterhitAdvantage":"'. $rs["CounterhitAdvantage"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>