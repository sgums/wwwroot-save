<?php
$server = "localhost\SQLEXPRESS";
$options = array(  "UID" => "sa",  "PWD" => "v0astr00t",  "Database" => "cms");
$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));

$sql = "exec comparison_rpt_gl";
$query = sqlsrv_query($conn, $sql);
if ($query === false)
{  
	exit("<pre>".print_r(sqlsrv_errors(), true));
}
echo "<table>";
echo "<tr><td>Split Skill</td>
	<td>Agents</br>Staffed</td>
    <td>Agents</br>Available</td>
	<td>Agents</br>in ACW</td>
    <td>Calls</br>Waiting</td>
	<td>Oldest Call</br>Waiting</td>
	<td>ACD</br>Calls</td>
	<td>Average</br>ACD Time</td>
	<td>Abandon</br>Calls</td>
	<td>Average</br>Abandon Time</td>
	<td>Average</br>Speed Answer</td>
	<td>Estimated Wait</br>Time Medium</td>
	<td>Average</br>ACW Time</td>
	<td>% Within</br>Service Level</td>	
	<td>% Abandon</br>Calls</td>	
    </tr>\n";

while ($row = sqlsrv_fetch_array($query))
{
	echo "\t<tr><td>$row[splitname]</td>\n";
	echo "\t\t<td>$row[staffed]</td>\n";
	echo "\t\t<td>$row[available]</td>\n";
	echo "\t\t<td>$row[inacw]</td>\n";
	echo "\t\t<td>$row[waiting]</td>\n";
	echo "\t\t<td>$row[oldest]</td>\n";
	echo "\t\t<td>$row[acdcalls]</td>\n";
	echo "\t\t<td>$row[att]</td>\n";
	echo "\t\t<td>$row[abncalls]</td>\n";
	echo "\t\t<td>$row[avg_abnt]</td>\n";
	echo "\t\t<td>$row[asa]</td>\n";
	echo "\t\t<td>$row[ewtMed]</td>\n";
	echo "\t\t<td>$row[avg_acwt]</td>\n";	
	echo "\t\t<td>$row[service_level]%</td>\n";
	echo "\t\t<td>$row[perc_abn]%</td>\n";	
	echo "\t</tr>\n";
}
echo "</table>";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>