
<?php
include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec graphStatGrp_split \"$_GET[grp]\"";
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
$abncalls = '0';

while ($row = sqlsrv_fetch_array($query))
{
	$svclvl = $row['svclvl'];
	$waiting = $row['waiting'];
	$oldest_seconds = $row['oldest_seconds'];
	$asa = $row['asa'];
	$acdcalls = $row['acdcalls'];
	$abncalls = $row['abncalls'];
}


echo "<table>";
echo "<tr><td><font class=\"LargeHeader\">Service Lvl</font></td><td>";
	if ( $svclvl < 90 )
		echo "<font class=\"inThreshold Large\">" . $svclvl . "%</font>";
	else
		echo "<font class=\"Large\">" . $svclvl . "</font>"; 
echo "</td></tr>";

echo "<tr><td><font class=\"LargeHeader\">Calls Waiting</font></td><td>";
	if ( $waiting > 0 )
		echo "<font class=\"inThreshold Large\">" . $waiting . "</font>";
	else
		echo "<font class=\"Large\">" . $waiting . "</font>"; 
echo "</td></tr>";
	
echo "<tr><td><font class=\"Medium\">Oldest Call Waiting</td><td>";
	if ($oldest_seconds > 30 )
	 echo "<font class=\"inThreshold Medium\">" . $oldest . "</font>";
	else
	 echo "<font class=\"Medium\">" . $oldest . "</font>";
echo "</td></tr>";	
	
echo "<tr><td><font class=\"Medium\">Average Speed Answer</font></td><td><font class=\"Medium\">". $asa ."</font></td></tr>";
echo "<tr><td><font class=\"Medium\">ACD Calls</font></td><td><font class=\"Medium\">" .$acdcalls . "</font></td></tr>";
echo "<tr><td><font class=\"Medium\">Aban Calls</font></td><td><font class=\"Medium\">" . $abncalls ."</font></td></tr>";
echo "</table>";			
?>