<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec llu_desktop_bottom \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
	
echo " <table>\n";	
echo "	<tr>
			<td>Agent ID</td>
			<td>Agent Name</td>
			<td>Current Skill</td>
			<td>Status</td>
			<td>Time in State</td>					
			</tr>\n";
					
while ($row = sqlsrv_fetch_array($query))
{
	echo "	<tr>\n";
	echo "	<td>$row[logid]</td>\n";
	echo "	<td>$row[name]</td>\n";
	echo "	<td>$row[worksplit]</td>\n";
	$mode = $row['workmode'];
	echo "	<td>$mode</td>\n";
	$thresh = "";
	$duration = $row['agtime'];
	if ( strpos($mode, 'ACD') !== false) {
		if ( $duration >= 900 and $duration < 1200 )
			$thresh = "class=\".inThresholdYellow\"";
		elseif ($duration >= 1200)
			$thresh = "class=\".inThresholdRed\"";
	}
	echo "	<td $thresh>$row[statetime]</td>\n";
	echo "	</tr>\n";
}
echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>