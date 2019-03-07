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
			<td>Current Split</td>
			<td>Status</td>
			<td>Time in State</td>					
			</tr>\n";
					
while ($row = sqlsrv_fetch_array($query))
{
	echo "	<tr>
				<td>$row[logid]</td>
				<td>$row[name]</td>
				<td>$row[worksplit]</td>
				<td>$row[workmode]</td>
				<td>$row[duration]</td>					
			</tr>\n";
}
echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>