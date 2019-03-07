<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec medline_desktop_bottom \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
	
echo " <table>\n";	
echo "	<tr>
			<td>Agent Name</td>
			<td>Agent ID</td>					
			<td>Time in State</td>					
			<td>Current Split</td>
			<td>Status</td>
			<td>Answered</td>
			</tr>\n";
					
while ($row = sqlsrv_fetch_array($query))
{
	echo "	<tr>
				<td>$row[name]</td>
				<td>$row[logid]</td>				
				<td>$row[duration]</td>
				<td>$row[worksplit]</td>
				<td>$row[workmode]</td>
				<td>0</td>					
			</tr>\n";
}
echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>