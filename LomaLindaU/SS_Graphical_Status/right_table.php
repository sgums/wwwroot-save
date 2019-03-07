<?php
include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec ss_graph_stat_spl_bygrp \"$_REQUEST[grp]\"";
$query = sqlsrv_query($conn, $sql);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$svclvl = '100.0';
$waiting = '0';
$oldest_seconds = '0';
$oldest = '0:00';
$asa = '0';
$asa_seconds = '0';
$acdcalls = '0';
$att = '0:00';
$abncalls = '0';
$avgabntime = '0:00';

while ($row = sqlsrv_fetch_array($query))
{
	$svclvl = $row['svclvl'];
	$waiting = $row['waiting'];
	$oldest_seconds = $row['oldest_seconds'];
	$oldest = $row['oldest'];
	$asa = $row['asa'];
	$acdcalls = $row['acdcalls'];
	$att = $row['att'];
	$abncalls = $row['abncalls'];
	$avgabntime = $row['avgabntime'];
	$asa_seconds = $row['asa_seconds'];
}


echo "<table>";
echo "<tr><td>% Within Service Level</td><td>";
	if ( $svclvl < 80 )
		echo "<font class=\"inThresholdDarkRed\">" . $svclvl . "</font>";
	else
		echo $svclvl; 
echo "%</td></tr>";

echo "<tr><td>Calls Waiting</td><td>";
	if ( $waiting > 0 )
		echo "<font class=\"inThreshold\">" . $waiting . "</font>";
	else
		echo $waiting;
echo "</td></tr>";
	
echo "<tr><td>Oldest Call Waiting</td><td>";
	if ($oldest_seconds > 45 and $oldest_seconds < 60 )
	 echo "<font class=\"inThresholdOrange\">" . $oldest . "</font>";
	elseif ($oldest_seconds >= 60)
		echo "<font class=\"inThresholdRed\">" . $oldest . "</font>";
	else
	 echo $oldest; 
echo "</td></tr>";	
	
echo "<tr><td>Average Speed Answer</td><td>";
	if ( $asa_seconds > 45 and $asa_seconds < 60 )
		echo "<font class=\"inThresholdOrange\">" . $asa . "</font>";
	elseif ($asa_seconds >= 60 )
		echo "<font class=\"inThresholdRed\">" . $asa . "</font>";
	else
		echo $asa;
echo "</td></tr>";


echo "<tr><td>ACD Calls</td><td>" .$acdcalls . "</td></tr>";
echo "<tr><td>Avg ACD Time</td><td>" . $att . "</td></tr>";
echo "<tr><td>Aban Calls</td><td>" . $abncalls ."</td></tr>";
echo "<tr><td>Avg Aban Time</td><td>" . $avgabntime . "</td></tr>";
echo "</table>";	
sqlsrv_free_stmt($query);
sqlsrv_close($conn);		
?>