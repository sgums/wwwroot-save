<?php

$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"icmsdata", "PWD"=>"icmsdata01!", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

echo "<table>";
echo "<tr><td>Skillset</td>
                        <td>
                            Calls</br>Waiting
                        </td>
                        <td >
                            Max Wait</br>Time
                        </td>
                        <td>
                            Total Agents</br>Staffed
                        </td>
			<td>
                            Total Agents</br>Unavailable
                        </td>
			<td>
                            Total Agents</br>Idle
                        </td>			
                    </tr>\n";

					
$sql = "exec wallboard1_synchronoss";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr><td>$row[group_name]</td>
		<td>$row[waiting]</td>
		<td>$row[oldest]</td>
		<td>$row[staffed]</td>
		<td>$row[unavailable]</td>
		<td>$row[available]</td>		
	</tr>\n";
}

echo "</table>";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>