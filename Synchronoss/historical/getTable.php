<?php
include 'dbinfo.php';

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

echo "<table>\n";
echo "<tr><td></td>
			<td>Calls</br>Offered</td>
			<td>Answered</td>
			<td>Abandoned</td>
			<td>Abandon %</td>
			<td>Average Speed</br> of Answer</td>
			<td>Average Handle</br>Time</td>
			<td>Service Level</br>Percent</td>
			<td>Percent Forecast</br>Offered</td>
			<td>Percent Forecast</br>Answered</td>
		</tr>\n";
	
$sql = "exec sync_hist \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
		
while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr><td>$row[name]</td>
		<td>$row[offered]</td>
		<td>$row[acdcalls]</td>
		<td>$row[abncalls]</td>
		<td>$row[perc_abn]%</td>
		<td>$row[asa]</td>
		<td>$row[aht]</td>
		<td>$row[svclvl]%</td>
		<td>$row[perc_forecast_offered]</td>
		<td>$row[perc_forecast_answered]</td>
	</tr>\n";
}

sqlsrv_free_stmt($query);	
	
$sql = "exec sync_hist_total \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr><td>Total Performance</td>
		<td>$row[offered]</td>
		<td>$row[acdcalls]</td>
		<td>$row[abncalls]</td>
		<td>$row[perc_abn]%</td>
		<td>$row[asa]</td>
		<td>$row[aht]</td>
		<td>$row[svclvl]%</td>
		<td>$row[perc_forecast_offered]</td>
		<td>$row[perc_forecast_answered]</td>
	</tr>\n";
}

echo "</table>\n";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>