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
		$sql= "SELECT " . $charName . ".*, Punisher.PunisherMove AS PunisherMove1, ABS(Punisher.Punishable) AS Punishable1
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
			AND (p.Input LIKE '1LP' OR p.Input LIKE '2LP' OR p.Input LIKE '3LP' OR p.Input LIKE '4LP' OR p.Input LIKE '5LP' OR p.Input LIKE '6LP'
			OR p.Input LIKE '1HP' OR p.Input LIKE '2HP' OR p.Input LIKE '3HP' OR p.Input LIKE '4HP' OR p.Input LIKE '5HP' OR p.Input LIKE '6HP'
			OR p.Input LIKE '1LK' OR p.Input LIKE '2LK' OR p.Input LIKE '3LK' OR p.Input LIKE '4LK' OR p.Input LIKE '5LK' OR p.Input LIKE '6LK'
			OR p.Input LIKE '1HK' OR p.Input LIKE '2HK' OR p.Input LIKE '3HK' OR p.Input LIKE '4HK' OR p.Input LIKE '5HK' OR p.Input LIKE '6HK')
			ORDER BY " . $charName . ".MoveId, p.Damage DESC
			) AS Punisher ON " . $charName . ".MoveName = Punisher.CharMove
		GROUP BY " . $charName . ".MoveName
		ORDER BY MoveID;";
	} else if ($punisher1 == "" && $punisher2 != "") {
		$sql= "SELECT " . $charName . ".*, Punisher.PunisherMove AS PunisherMove2, ABS(Punisher.Punishable) AS Punishable2
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
			AND (p.Input LIKE '1LP' OR p.Input LIKE '2LP' OR p.Input LIKE '3LP' OR p.Input LIKE '4LP' OR p.Input LIKE '5LP' OR p.Input LIKE '6LP'
			OR p.Input LIKE '1HP' OR p.Input LIKE '2HP' OR p.Input LIKE '3HP' OR p.Input LIKE '4HP' OR p.Input LIKE '5HP' OR p.Input LIKE '6HP'
			OR p.Input LIKE '1LK' OR p.Input LIKE '2LK' OR p.Input LIKE '3LK' OR p.Input LIKE '4LK' OR p.Input LIKE '5LK' OR p.Input LIKE '6LK'
			OR p.Input LIKE '1HK' OR p.Input LIKE '2HK' OR p.Input LIKE '3HK' OR p.Input LIKE '4HK' OR p.Input LIKE '5HK' OR p.Input LIKE '6HK')
			ORDER BY " . $charName . ".MoveId, p.Damage DESC
			) AS Punisher ON " . $charName . ".MoveName = Punisher.CharMove
		GROUP BY " . $charName . ".MoveName
		ORDER BY MoveID;";
	} else if ($punisher1 != "" && $punisher2 != "") {
		$sql= "SELECT " . $charName . ".*, Punisher.PunisherMove AS PunisherMove1, ABS(Punisher.Punishable) AS Punishable1, Punisher2.PunisherMove AS PunisherMove2, ABS(Punisher2.Punishable) AS Punishable2
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
			AND (p.Input LIKE '1LP' OR p.Input LIKE '2LP' OR p.Input LIKE '3LP' OR p.Input LIKE '4LP' OR p.Input LIKE '5LP' OR p.Input LIKE '6LP'
			OR p.Input LIKE '1HP' OR p.Input LIKE '2HP' OR p.Input LIKE '3HP' OR p.Input LIKE '4HP' OR p.Input LIKE '5HP' OR p.Input LIKE '6HP'
			OR p.Input LIKE '1LK' OR p.Input LIKE '2LK' OR p.Input LIKE '3LK' OR p.Input LIKE '4LK' OR p.Input LIKE '5LK' OR p.Input LIKE '6LK'
			OR p.Input LIKE '1HK' OR p.Input LIKE '2HK' OR p.Input LIKE '3HK' OR p.Input LIKE '4HK' OR p.Input LIKE '5HK' OR p.Input LIKE '6HK')
			ORDER BY " . $charName . ".MoveId, p.Damage DESC
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
			AND (p.Input LIKE '1LP' OR p.Input LIKE '2LP' OR p.Input LIKE '3LP' OR p.Input LIKE '4LP' OR p.Input LIKE '5LP' OR p.Input LIKE '6LP'
			OR p.Input LIKE '1HP' OR p.Input LIKE '2HP' OR p.Input LIKE '3HP' OR p.Input LIKE '4HP' OR p.Input LIKE '5HP' OR p.Input LIKE '6HP'
			OR p.Input LIKE '1LK' OR p.Input LIKE '2LK' OR p.Input LIKE '3LK' OR p.Input LIKE '4LK' OR p.Input LIKE '5LK' OR p.Input LIKE '6LK'
			OR p.Input LIKE '1HK' OR p.Input LIKE '2HK' OR p.Input LIKE '3HK' OR p.Input LIKE '4HK' OR p.Input LIKE '5HK' OR p.Input LIKE '6HK')
			ORDER BY " . $charName . ".MoveId, p.Damage DESC
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
	
	if ($result->fetch_array(MYSQLI_ASSOC) == "") {
		echo($charName . "'s frame data is not currently available.");
	}
	
	else {
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
			$outp .= '"HitAdvantage":"' . $rs["HitAdvantage"];
			if ($punisher1 != "") {
				if ($rs["Punishable1"] != "") {
					$outp .= '","Punisher1":"' . $rs["PunisherMove1"];
					$outp .= '","Punisher1Opening":"' . $rs["Punishable1"];
				}
			}
			if ($punisher2 != "") {
				if ($rs["Punishable2"] != "") {
					$outp .= '","Punisher2":"' . $rs["PunisherMove2"];
					$outp .= '","Punisher2Opening":"' . $rs["Punishable2"];
				}
			}
			$outp .= '"}';
		}
		$outp ='{"records":['.$outp.']}';
		$conn->close();
		
		echo($outp);
	}
}

getFrameData();
?>