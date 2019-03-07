<?php

function initTenDayValues () {
	return array (
		"700" => 0, "730" => 0, "800" => 0, "830" => 0, "900" => 0, "930" => 0, "1000" => 0, "1030" => 0, "1100" => 0,
		"1130" => 0, "1200" => 0, "1230" => 0, "1300" => 0, "1330" => 0, "1400" => 0, "1430" => 0, "1500" => 0, "1530" => 0, "1600" => 0, "1630" => 0,
		"1700" => 0);
}

function initTodaysValues () {
	return array (
		"700" => 0, "730" => 0, "800" => 0, "830" => 0, "900" => 0, "930" => 0, "1000" => 0, "1030" => 0, "1100" => 0,
		"1130" => 0, "1200" => 0, "1230" => 0, "1300" => 0, "1330" => 0, "1400" => 0, "1430" => 0, "1500" => 0, "1530" => 0, "1600" => 0, "1630" => 0,
		"1700" => 0);	
}

function loadTenDays ($a, $conn, $spl) {	
	$sql = "execute last10weeks " . $spl;	
	$query = sqlsrv_query($conn, $sql);
	if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));
	
	while ($row = sqlsrv_fetch_array($query))
	{		
		$interval = $row["starttime"];
		$offered = $row["offered"];
		$a[$interval]=$offered;			
	}//loop through intervals from last 10 day query.
	return $a;
}

function loadTodayValues($a, $conn, $spl) {
	$sql = "execute todayValues " . $spl;
	$query = sqlsrv_query($conn, $sql);
	if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));
	
	while ($row = sqlsrv_fetch_array($query))
	{
		$interval = $row["starttime"];
		$offered = $row["offered"];
		$a[$interval]=$offered;		
	}//loop through intervals from last 10 day query.	
	return $a;
}

function getCurrentValue ($conn, $spl) {	
	$sql = "execute currentValue " . $spl;
	$query = sqlsrv_query($conn, $sql);
	if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));
	
	while ($row = sqlsrv_fetch_array($query))
	{		
		$offered = $row["offered"];			
	}//loop through intervals from last 10 day query.	
	return $offered;
}

function getCurrentInterval () {
	if (date("i") <= 30 ) {
		$cInt = (string)date("G") . "00";
	}
	else {
		$cInt = (string)date("G") . "30";
	}
	return $cInt; 
}

include 'vars.php';
$spl = $_REQUEST['grp'];
$conn = sqlsrv_connect ($server, $options);

if ( $conn == false) ("<pre>" . print_r(sqlsrv_errors(), true));

session_start();

//used for debugging.
//unset($_SESSION["currentDate"]);

$currentDate = "";
$tenDayValues = "";
$todayValues = "";
$currentDOW = "";

if ( !isset($_SESSION["currentDate"]) )
{	
	$today = date("m/d/Y");
	$_SESSION["currentDate"] = $today;
	$date_array = getdate();
	$currentDOW = $date_array['weekday'];
	
	$tenDayValues = initTenDayValues();
	$todayValues = initTodaysValues();
	
	$tenDayValues = loadTenDays ($tenDayValues, $conn, $spl);
	$todayValues = loadTodayValues ($todayValues, $conn, $spl);
		
	$_SESSION["tenDayValues"] = $tenDayValues;
	$_SESSION["todayValues"] = $todayValues;
} //If session wasn't set before, set and initialize
else {		
	$currentDate = $_SESSION["currentDate"];
	$tenDayValues = $_SESSION["tenDayValues"];
	$todayValues = $_SESSION["todayValues"];
	$date_array = getdate();
	$currentDOW = $date_array['weekday'];
}

$today = date("m/d/Y");

//echo "<p>Today is " . $today . " and current date is " . $currentDate . "</p>";

if ($today != $currentDate)
{
	$tenDayValues = loadTenDays ($tenDayValues, $conn, $spl);
	$_SESSION["tenDayValues"] = $tenDayValues;
	
	//set so it doesn't query next time.
	$_SESSION["currentDate"] = $today;	
	
	//re-init today values back to zero.
	$todayValues = initTodaysValues();	
	$todayValues = $_SESSION["todayValues"];		
} //end of update if date is different.

//Get current interval
$currentInterval = getCurrentInterval($spl);
if ( array_key_exists ($currentInterval, $todayValues) ) {
	$todayValues[$currentInterval] = getCurrentValue($conn, $spl);
	$_SESSION["todayValues"] = $todayValues;
}

//Now print everything out.
echo "<chart>\n";
echo "\t<chart_data>\n";
echo "\t\t<row>\n";
echo "			<null/>\n";
echo "			<string>7:00</string>\n";
echo "			<string>7:30</string>\n";
echo "			<string>8:00</string>\n";
echo "			<string>8:30</string>\n";
echo "			<string>9:00</string>\n";
echo "			<string>9:30</string>\n";
echo "			<string>10:00</string>\n";
echo "			<string>10:30</string>\n";
echo "			<string>11:00</string>\n";
echo "			<string>11:30</string>\n";
echo "			<string>12:00</string>\n";
echo "			<string>12:30</string>\n";
echo "			<string>13:00</string>\n";
echo "			<string>13:30</string>\n";
echo "			<string>14:00</string>\n";
echo "			<string>14:30</string>\n";
echo "			<string>15:00</string>\n";
echo "			<string>15:30</string>\n";
echo "			<string>16:00</string>\n";
echo "			<string>16:30</string>\n";
echo "			<string>17:00</string>\n";
echo "\t\t</row>\n";
//Loop through 10 day values
echo "\t\t<row>\n";
echo "			<string>Last Ten " . $currentDOW . "s</string>\n";
while (list($int, $off) = each ($tenDayValues) )
{
	echo "\t\t\t<number bevel='bevel1' shadow='high'>" . $off . "</number>\n";
}
echo "\t\t</row>\n";

//Current Days Data
echo "\t\t<row>\n";
echo "			<string>Today</string>\n";
while (list($int, $off) = each ($todayValues) )
{
	echo "\t\t\t<number>" . $off . "</number>\n";	
}
echo "\t\t</row>\n";


echo "\t</chart_data>\n";
echo "\t<update url='data.php?grp=". $spl. "' delay='4' mode='data' />\n";
echo "</chart>\n";

?>

