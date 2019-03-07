<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec biorad_split \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
	
echo " <table>\n";	
echo "	<tr>
			<td>Split</td>
			<td>Staffed</td>
			<td>Avg Speed Answer</td>
			<td>Service Level</td>
			<td>Calls Waiting</td>
			<td>Calls Offered</td>
			<td>Calls Answered</td>
			<td>Calls Abandon</td>
			<td>Max Wait Time</td>					
		</tr>\n";
					
while ($row = sqlsrv_fetch_array($query))
{
	echo "	<tr>
				<td>$row[splitname]</td>
				<td>$row[staffed]</td>
				<td>$row[asa]</td>
				<td>$row[svclvl]%</td>
				<td>$row[waiting]</td>
				<td>$row[offered]</td>
				<td>$row[acdcalls]</td>
				<td>$row[abncalls]</td>
				<td>$row[oldest]</td>					
			</tr>\n";
}
echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>