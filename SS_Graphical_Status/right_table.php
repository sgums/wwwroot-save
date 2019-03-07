
<?php
$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa", "PWD"=>"v0astr00t", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec ss_graph_stat_right_table_data \"Operator_Services\"";
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
$acdcalls = '0';
$att = '0:00';
$abncalls = '0';
$avgabntime = '0:00';

while ($row = sqlsrv_fetch_array($query))
{
	$svclvl = $row['svclvl'];
	$waiting = $row['waiting'];
	$oldest_seconds = $row['oldest_seconds'];
	$asa = $row['asa'];
	$acdcalls = $row['acdcalls'];
	$att = $row['att'];
	$abncalls = $row['abncalls'];
	$avgabntime = $row['avgabntime'];
}


echo "<table>";
echo "<tr><td>% Within Service Level</td><td>";
	if ( $svclvl < 90 )
		echo "<font class=\"inThreshold\">" . $svclvl . "</font>";
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
	if ($oldest_seconds > 30 )
	 echo "<font class=\"inThreshold\">" . $oldest . "</font>";
	else
	 echo $oldest; 
echo "</td></tr>";	
	
echo "<tr><td>Average Speed Answer</td><td>". $asa ."</td></tr>";
echo "<tr><td>ACD Calls</td><td>" .$acdcalls . "</td></tr>";
echo "<tr><td>Avg ACD Time</td><td>" . $att . "</td></tr>";
echo "<tr><td>Aban Calls</td><td>" . $abncalls ."</td></tr>";
echo "<tr><td>Avg Aban Time</td><td>" . $avgabntime . "</td></tr>";
echo "</table>";			
?>