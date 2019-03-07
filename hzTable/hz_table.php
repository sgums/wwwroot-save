<?php

$server = "localhost\SQLEXPRESS";
$options = array(  "UID" => "sa",  "PWD" => "v0astr00t",  "Database" => "tester");
$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));

$sql = "exec web_report_view";
$query = sqlsrv_query($conn, $sql);
if ($query === false)
{  
	exit("<pre>".print_r(sqlsrv_errors(), true));
}

echo "<table border=1>";
$names = "<td></td>";
/*$SkillState = "<td>Skill State</td>"; */
$staffed = "<td>Agents Staffed</td>";
$waiting = "<td>Calls Waiting</td>";
$oldest = "<td>Oldest Call Waiting</td>";
$acdc = "<td>ACD Calls</td>";
$acdt = "<td>Avg ACD Time</td>";
$abnc = "<td>Aban Calls</td>";
$abnt = "<td>Avg Aban Time</td>";
$asa = "<td>Avg Speed Ans</td>";

while ($row = sqlsrv_fetch_array($query))
{
	switch ($row['split']) {
		case 303:
			$names .= "<td>General</td>";
			break;
		case 304:
			$names .= "<td>Clinic</td>";
			break;
		case 305:
			$names .= "<td>Password</td>";
			break;
		default:
			$names .= "<td>Not Defined</td>";
	}
	/* $names .= "<td>" . $row['splitname'] . "</td>"; */
	/*$SkillState .= "<td>" . $row['skstate'] . "</td>";	*/
	$staffed .= "<td>" . $row['staffed'] . "</td>";
	$waiting .= "<td><font class=\"" . $row['waitingClass'] . "\">" . $row['waiting'] . "</font></td>";
	$oldest .= "<td><font class=\"" . $row['oldestClass'] . "\">" . $row['oldest'] . "</font></td>";
	$acdc .= "<td>" . $row['acdcalls'] . "</td>";
	$acdt .= "<td>" . $row['AvgTalkTime'] . "</td>";
	$abnc .= "<td>" . $row['abncalls'] . "</td>";
	$abnt .= "<td>" . $row['AvgAbnTime'] . "</td>";
	$asa .= "<td>" . $row['ASA'] . "</td>";	
}

echo "<tr>" . $names . "</tr>";
/*echo "<tr>" . $SkillState . "</tr>";*/
echo "<tr>" . $staffed . "</tr>";
echo "<tr>" . $waiting . "</tr>";
echo "<tr>" . $oldest . "</tr>";
echo "<tr>" . $acdc . "</tr>";
echo "<tr>" . $acdt . "</tr>";
echo "<tr>" . $abnc . "</tr>";
echo "<tr>" . $abnt . "</tr>";
echo "<tr>" . $asa . "</tr>";
echo "</table>";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);

?>