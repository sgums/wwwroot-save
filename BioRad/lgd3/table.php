<?php

include 'vars.php';
$location = 0;

if ( isset($_REQUEST['location']) )
{
	 $location = $_REQUEST['location'];	
}

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec lgd3 \"$location\"";
$query = sqlsrv_query($conn, $sql);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
	
echo " <table>\n";	
echo "	<tr>	 
	 <td>Skills<br/>Selected Option</td>
	 <td>Calls Waiting</td>	 
	 <td>Longest Waiting</td>
	 <td>Calls<br/>Answered</td>
	 <td>Calls Diverted</td>
	 <td>Abandon<br/>Calls</td>
	 <td>Staffed CTS Reps</td>
	 <td>Available CTS Reps</td>
	</tr>";	
	
while ($row = sqlsrv_fetch_array($query))
{
	$oldest_secs = $row['oldest_seconds'];	
	echo "	<tr>";
	if ( $location != 0)
		echo "   <td class=\"tooltip\">$row[name]<span class=\"tooltiptext\">VDN:$row[vdn]</span></td>";
	else
		echo "   <td>$row[name]</td>";
	echo "   <td>$row[waiting]</td>";
	if ( $oldest_secs >= 20 )
		echo "   <td id=\"inThreshold\">$row[oldest]</td>";
	else
		echo "   <td>$row[oldest]</td>";

	echo "   <td>$row[acdcalls]</td>";
	echo "   <td>$row[outflow]</td>";
	echo "   <td>$row[abncalls]</td>";
	echo "   <td>$row[staffed]</td>";
	echo "   <td>$row[available]</td>";
}

echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>