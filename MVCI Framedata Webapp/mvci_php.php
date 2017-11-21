<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

function connect(){
	$servername = "ktangdb.clb60p2aechx.us-east-2.rds.amazonaws.com";
	$username = "publicuser";
	$password = "password";
	$dbname = "KtangDB";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}

function getSqlString($charName, $punisher1, $punisher2) {	
	if ($punisher1 != "" && $punisher2 == "") {
		$sql= "SELECT " . $charName . ".*, Punisher.PunisherMove, Punisher.Punishable AS Punishable1
		FROM " . $charName . "
		LEFT JOIN (
			SELECT " . $charName . ".MoveName as CharMove, p.MoveName as PunisherMove, p.Startup+" . $charName . ".BlockAdvantage as Punishable
			FROM " . $charName . " 
			INNER JOIN " . $punisher1 . " p on ABS(" . $charName . ".BlockAdvantage) > p.Startup
			WHERE " . $charName . ".Damage IS NOT NULL
			AND " . $charName . ".BlockAdvantage < 0
			AND " . $charName . ".MoveName NOT LIKE 'Throw%'
			AND p.Damage > 0
			AND p.Startup IS NOT NULL
			AND p.MoveName NOT LIKE 'Throw%'
			AND p.MoveName NOT LIKE '>%'
			AND p.MoveName NOT LIKE 'Flight%'
			) AS Punisher ON " . $charName . ".MoveName = Punisher.CharMove
		GROUP BY " . $charName . ".MoveName
		ORDER BY MoveID;";
	} else if ($punisher1 == "" && $punisher2 != "") {
		$sql= "SELECT " . $charName . ".*, Punisher.PunisherMove, Punisher.Punishable AS Punishable2
		FROM " . $charName . "
		LEFT JOIN (
			SELECT " . $charName . ".MoveName as CharMove, p.MoveName as PunisherMove, p.Startup+" . $charName . ".BlockAdvantage as Punishable
			FROM " . $charName . " 
			INNER JOIN " . $punisher2 . " p on ABS(" . $charName . ".BlockAdvantage) > p.Startup
			WHERE " . $charName . ".Damage IS NOT NULL
			AND " . $charName . ".BlockAdvantage < 0
			AND " . $charName . ".MoveName NOT LIKE 'Throw%'
			AND p.Damage > 0
			AND p.Startup IS NOT NULL
			AND p.MoveName NOT LIKE 'Throw%'
			AND p.MoveName NOT LIKE '>%'
			AND p.MoveName NOT LIKE 'Flight%'
			) AS Punisher ON " . $charName . ".MoveName = Punisher.CharMove
		GROUP BY " . $charName . ".MoveName
		ORDER BY MoveID;";
	} else if ($punisher1 != "" && $punisher2 != "") {
		$sql= "SELECT " . $charName . ".*, Punisher.PunisherMove, Punisher.Punishable AS Punishable1, Punisher2.PunisherMove, Punisher2.Punishable AS Punishable2
		FROM " . $charName . "
		LEFT JOIN (
			SELECT " . $charName . ".MoveName as CharMove, p.MoveName as PunisherMove, p.Startup+" . $charName . ".BlockAdvantage as Punishable
			FROM " . $charName . " 
			INNER JOIN " . $punisher1 . " p on ABS(" . $charName . ".BlockAdvantage) > p.Startup
			WHERE " . $charName . ".Damage IS NOT NULL
			AND " . $charName . ".BlockAdvantage < 0
			AND " . $charName . ".MoveName NOT LIKE 'Throw%'
			AND p.Damage > 0
			AND p.Startup IS NOT NULL
			AND p.MoveName NOT LIKE 'Throw%'
			AND p.MoveName NOT LIKE '>%'
			AND p.MoveName NOT LIKE 'Flight%'
			) AS Punisher ON " . $charName . ".MoveName = Punisher.CharMove
		LEFT JOIN (
			SELECT " . $charName . ".MoveName as CharMove, p.MoveName as PunisherMove, p.Startup+" . $charName . ".BlockAdvantage as Punishable
			FROM " . $charName . " 
			INNER JOIN " . $punisher2 . " p on ABS(" . $charName . ".BlockAdvantage) > p.Startup
			WHERE " . $charName . ".Damage IS NOT NULL
			AND " . $charName . ".BlockAdvantage < 0
			AND " . $charName . ".MoveName NOT LIKE 'Throw%'
			AND p.Damage > 0
			AND p.Startup IS NOT NULL
			AND p.MoveName NOT LIKE 'Throw%'
			AND p.MoveName NOT LIKE '>%'
			AND p.MoveName NOT LIKE 'Flight%'
			) AS Punisher2 ON " . $charName . ".MoveName = Punisher2.CharMove
		GROUP BY " . $charName . ".MoveName
		ORDER BY MoveID;";
	} else {
		$sql = "SELECT * FROM " . $charName . ";";
	}
	return $sql;
} 

function getFrameData(){
	$charName = $_GET['characterValue'];
	$punisher1 = $_GET['punisher1'];
	$punisher2 = $_GET['punisher2'];
	
	$conn = connect();
	$sql = getSqlString($charName, $punisher1, $punisher2);
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
		$outp .= '"CounterhitAdvantage":"'. $rs["CounterhitAdvantage"];
		if ($punisher1 != "") {
			//$outp .= '","Punisher1":"' . $rs["Punishable1"];
			if ($rs["Punishable1"] != "") {
				$outp .= '","Punisher1": "Yes';
			} else {
				$outp .= '","Punisher1":"' . $rs["Punishable1"];
			}
		}
		if ($punisher2 != "") {
			//$outp .= '","Punisher1":"' . $rs["Punishable1"];
			if ($rs["Punishable2"] != "") {
				$outp .= '","Punisher2": "Yes';
			} else {
				$outp .= '","Punisher2":"' . $rs["Punishable2"];
			}
		}
		$outp .= '"}';
	}
	$outp ='{"records":['.$outp.']}';
	$conn->close();
	
	echo($outp);
}

getFrameData();
?>