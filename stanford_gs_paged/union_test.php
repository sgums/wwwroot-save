<?php
include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

//$sql = "select *, ROW_NUMBER () over (order by logid) rowNumber from (select * from rt_agent union all select * from rt_agent_acd2) a";
$sql = "select *, count(workmode) as workmode_count from " .
"(select workmode from rt_agent WHERE ti_stafftime > 0 and split in (select split from split_groups where group_name='operator_services' and acd=1)" .
" union all select workmode from rt_agent_acd2 WHERE ti_stafftime > 0 and split in (select split from split_groups where group_name='operator_services' and acd=2)" .
" ) a group by workmode";
echo "<p>" . $sql . "</p>";
$query = sqlsrv_query($conn, $sql);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}


echo "<html><body><table>\n";
while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr>";
	echo "<td>" . $row['workmode'] . "</td>";
	echo "<td>" . $row['workmode_count'] . "</td>";
	//echo "<td>" . $row['rowNumber'] . "</td>";
	echo "</tr>\n";
}
echo "</table></body></html>\n";

?>