<?php

$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"icmsdata", "PWD"=>"icmsdata01!", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

echo "<table>";
echo "<tr><td>Agent Name</td>
                        <td>
                            Current</br>State
                        </td>
                        <td>
                            Time in</br>State
                        </td>
                        <td>
                            Scheduled</br>State
                        </td>
			<td>
                            Time Out of</br>Adherence
                        </td>					
                    </tr>\n";

$sql = "exec agent_states \"$_GET[spl]\"";
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
		<td>$row[workmode]</td>
		<td>$row[time_in_state]</td>
		<td>$row[scheduled_state]</td>
		<td>$row[time_out_of_adherence]</td>		
	</tr>\n";
}
					
				
echo "</table>";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>