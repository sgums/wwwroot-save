<?php

function initTenDayValues () {
	return array (
		"600" => 0, "630" => 0, "700" => 0, "730" => 0, "800" => 0, "830" => 0, "900" => 0, "930" => 0, "1000" => 0, "1030" => 0, "1100" => 0,
		"1130" => 0, "1200" => 0, "1230" => 0, "1300" => 0, "1330" => 0, "1400" => 0, "1430" => 0, "1500" => 0, "1530" => 0, "1600" => 0, "1630" => 0,
		"1700" => 0, "1730" => 0, "1800" => 0, "1830" => 0, "1900" => 0, "1930" => 0, "2000" => 0,);
}

function initTodaysValues () {
	return array (
		"600" => 0, "630" => 0, "700" => 0, "730" => 0, "800" => 0, "830" => 0, "900" => 0, "930" => 0, "1000" => 0, "1030" => 0, "1100" => 0,
		"1130" => 0, "1200" => 0, "1230" => 0, "1300" => 0, "1330" => 0, "1400" => 0, "1430" => 0, "1500" => 0, "1530" => 0, "1600" => 0, "1630" => 0,
		"1700" => 0, "1730" => 0, "1800" => 0, "1830" => 0, "1900" => 0, "1930" => 0, "2000" => 0,);	
}

function loadTenDays ($a, $conn) {
	$sql = "execute last10days;";
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

function loadTodayValues($a, $conn) {
	$sql = "execute todayValues;";
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

function getCurrentValue ($conn) {
	$sql = "execute currentValue;";
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

$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa","PWD"=>"v0astr00t","Database"=>"tester");
$conn = sqlsrv_connect ($server, $options);

if ( $conn == false) ("<pre>" . print_r(sqlsrv_errors(), true));

session_start();

//used for debugging.
unset($_SESSION["currentDate"]);

$currentDate = "";
$tenDayValues = "";
$todayValues = "";

if ( !isset($_SESSION["currentDate"]) )
{	
	$today = date("m/d/Y");
	$_SESSION["currentDate"] = $today;

	$tenDayValues = initTenDayValues();
	$todayValues = initTodaysValues();

	$tenDayValues = loadTenDays ($tenDayValues, $conn);
	$todayValues = loadTodayValues ($todayValues, $conn);
		
	$_SESSION["tenDayValues"] = $tenDayValues;
	$_SESSION["todayValues"] = $todayValues;
} //If session wasn't set before, set and initialize
else {		
	$currentDate = $_SESSION["currentDate"];
	$tenDayValues = $_SESSION["tenDayValues"];
	$todayValues = $_SESSION["todayValues"];
}

$today = date("m/d/Y");

if ($today != $currentDate)
{
	$tenDayValues = loadTenDays ($tenDayValues, $conn);
	$_SESSION["tenDayValues"] = $tenDayValues;
	
	//set so it doesn't query next time.
	$_SESSION["currentDate"] = $today;	
	
	//re-init today values back to zero.
	$todayValues = initTodaysValues();	
	$todayValues = $_SESSION["todayValues"];		
} //end of update if date is different.

//Get current interval
$currentInterval = getCurrentInterval();
if ( array_key_exists ($currentInterval, $todayValues) ) {
	$todayValues[$currentInterval] = getCurrentValue($conn);
	$_SESSION["todayValues"] = $todayValues;
}

//Now print everything out.
echo "<chart>\n";
echo "\t<chart_data>\n";
echo "\t\t<row>\n";
echo "			<null/>\n";
echo "			<string>6:00</string>\n";
echo "			<string>6:30</string>\n";
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
echo "			<string>17:30</string>\n";
echo "			<string>18:00</string>\n";
echo "			<string>18:30</string>\n";
echo "			<string>19:00</string>\n";
echo "			<string>19:30</string>\n";
echo "			<string>20:00</string>\n";
echo "\t\t</row>\n";
//Loop through 10 day values
echo "\t\t<row>\n";
echo "			<string>Last Ten Days</string>\n";
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
echo "\t<update url='http://localhost/comparison/data.php' delay='4' mode='data' />\n";
echo "</chart>\n";

?>

