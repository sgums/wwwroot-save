<?php
$server = "localhost\SQLEXPRESS";
$options = array(  "UID" => "sa",  "PWD" => "v0astr00t",  "Database" => "cms");
$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));

$sql = "exec web_report_view";
$query = sqlsrv_query($conn, $sql);
if ($query === false)
{  
	exit("<pre>".print_r(sqlsrv_errors(), true));
}
echo "<table>";
echo "<tr><td>Group</td>
                        <td>
                            HR Specialists</br>Staffed
                        </td>
                        <td >
                            HR Specialists</br>Available
                        </td>
                        <td>
                            Calls</br>Waiting
                        </td>
			<td>
                            Oldest Call</br>Waiting
                        </td>
			<td>
                            Calls</br>Offered
                        </td>
			<td>
                            ACD</br>Calls
                        </td>
			<td>
                            Abandon</br>Calls
                        </td>
			<td>
			    Service</br>Level
			</td>	
			<td>
			    Last</br>Updated
			</td>
                    </tr>\n";

while ($row = sqlsrv_fetch_array($query))
{
	echo "\t<tr><td>$row[splitname]</td>\n";
	echo "\t\t<td>$row[staffed]</td>\n";
	echo "\t\t<td>$row[available]</td>\n";
	echo "\t\t<td>$row[waiting]</td>\n";
	echo "\t\t<td>$row[oldest]</td>\n";
	echo "\t\t<td>$row[offered]</td>\n";
	echo "\t\t<td>$row[acdcalls]</td>\n";
	echo "\t\t<td>$row[abncalls]</td>\n";
	echo "\t\t<td>$row[service_level]%</td>\n";
	echo "\t\t<td>$row[lastupdated]</td>\n";	
	echo "\t</tr>\n";
}
echo "</table>";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>