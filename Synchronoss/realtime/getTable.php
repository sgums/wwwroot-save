<?php
include 'dbinfo.php';

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec sync_realtime";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$elite1Tbl='';
$elite2Tbl='';

while ($row = sqlsrv_fetch_array($query))
{	
	if ( strcmp($row['group_name'],'Elite 1') ) {			
		$elite1Tbl .= "<tr>
			<td>$row[display_name]</td>
			<td>$row[waiting]</td>
			<td>$row[oldest]</td>
			<td>$row[asa]</td>
			<td>$row[staffed]</td>
			<td>$row[onacd]</td>
			<td>$row[available]</td>			
			<td>$row[unavailable]</td>			
		</tr>\n"; }
	else {
		$elite2Tbl .= "<tr>
			<td>$row[display_name]</td>
			<td>$row[waiting]</td>
			<td>$row[oldest]</td>
			<td>$row[asa]</td>
			<td>$row[staffed]</td>
			<td>$row[onacd]</td>
			<td>$row[available]</td>			
			<td>$row[unavailable]</td>			
		</tr>\n";	
	}
}


echo "<div class=\"top\">
	<div class=\"CSSTableGenerator\">
		<table>
		 <tr><td>Elite 1</td>
			<td>Calls in</br>Queue</td>
			<td>Max Wait</br>Time</td>
			<td>ASA</td>
			<td>Total Agents</br>Staffed</td>
			<td>Active Agents</td>
			<td>Idle Agents</td>
			<td>Unavailable</br>Agents</td>
		</tr>
		$elite1Tbl
		</table>
		</div>
	</div>

	<div class=\"middle\">
		<div class=\"CSSTableGenerator\">
		<table>
		 <tr><td>Elite 2</td>
			<td>Calls in</br>Queue</td>
			<td>Max Wait</br>Time</td>
			<td>ASA</td>
			<td>Total Agents</br>Staffed</td>
			<td>Active Agents</td>
			<td>Idle Agents</td>
			<td>Unavailable</br>Agents</td>
		</tr>
		$elite2Tbl
		</table>
		</div>
	</div>
\n";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>