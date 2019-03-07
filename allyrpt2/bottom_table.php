
<?php
include 'vars.php';
if ( !isset($_REQUEST['spl']) )
{
	 echo "<p>Split parameter not entered</p>";	
	 exit ("</html>");
}

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec splitTotals @spl=\"$_GET[spl]\"";
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
$rona = 0;

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
	$oldest = $row['oldest'];
	$rona = $row['noansredir'];
}

echo "<div class=\"bottomleft CSSTableGenerator\">\n";
echo "		 <table>\n";
echo "<tr><td>Calls Waiting</td><td>";
    
	if ( $waiting > 1 )
		echo "<font class=\"inThreshold\">" . $waiting . "</font>";
	else
	
		echo $waiting;
echo "</td></tr>";
echo "<tr><td>Oldest Call Waiting</td><td>";
	
	if ($oldest_seconds > 300 )
	 echo "<font class=\"inThreshold\">" . $oldest . "</font>";
	else
	
	 echo $oldest; 
echo "</td></tr>";
echo "<tr><td>% Within Service Level</td><td>";
   /*
	if ( $svclvl < 90 )
		echo "<font class=\"inThreshold\">" . $svclvl . "</font>";
	else
	*/
		echo $svclvl; 
echo "%</td></tr>";
echo "<tr><td>Average Speed Answer</td><td>". $asa ."</td></tr>";
echo "		</table>\n";
echo "		</div>\n";
echo "		<div class=\"bottomright CSSTableGenerator\">\n";
echo "		<table>\n";
echo "<tr><td>ACD Calls</td><td>" .$acdcalls . "</td></tr>";
echo "<tr><td>Avg ACD Time</td><td>" . $att . "</td></tr>";
echo "<tr><td>Aban Calls / Time</td><td>" . $abncalls ." / " . $avgabntime . "</td></tr>";
echo "<tr><td>RONA</td><td>" . $rona . "</td></tr>";
echo "		</table>\n";
echo "		</div>\n";
echo "<table>";



	
	


	





echo "</table>";			
?>