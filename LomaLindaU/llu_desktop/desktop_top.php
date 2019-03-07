<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$grp = $_REQUEST['grp'];
$sql = "exec llu_desktop_top \"$grp\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
echo " <table>\n";
echo "	<tr>
			<td>Skill</td>
			<td>Avg Speed Answer</td>
			<td>Service Level</td>			
			<td>Calls Offered</td>
			<td>Calls Answered</td>
			<td>Calls Abandon</td>
			<td>Calls Waiting</td>
			<td>Max Wait Time</td>					
		</tr>\n";
					
while ($row = sqlsrv_fetch_array($query))
{
	echo "	<tr>\n";
	echo "		<td>$row[splitname]</td>\n";
	$asaSec = $row['asa_sec'];
	if ( $asaSec > 45 )
		if ($asaSec > 60)
			echo "		<td class=\"inThresholdRed\">$row[asa]</td>\n";
		else	
			echo "		<td class=\"inThresholdOrange\">$row[asa]</td>\n";
	else	
		echo "		<td>$row[asa]</td>\n";
	echo "		<td>$row[svclvl]%</td>\n";
	echo "		<td>$row[offered]</td>\n";
	echo "		<td>$row[acdcalls]</td>\n";
	echo "		<td>$row[abncalls]</td>\n";
	echo "		<td>$row[waiting]</td>\n";
	echo "		<td>$row[oldest]</td>\n";
	echo "	</tr>\n";
}
echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>