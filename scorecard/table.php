<?php

$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa", "PWD"=>"v0astr00t", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec agent_scoreboard \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row_count = sqlsrv_num_rows($query);
$i = 0;

echo "<table>";
echo "<tr>";
echo "<td>Agent</td>";
echo "<td>Calls Offered</td>";
echo "<td>Calls Answered</td>";
echo "<td>RONAs</td>";
echo "<td>Total Talk Time</td>";
echo "<td>Percent in Aux Mode</td>";
echo "</tr>";

while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['offered'] . "</td>";
	echo "<td>" . $row['acdcalls'] . "</td>";
	echo "<td>" . $row['rona'] . "</td>";
	echo "<td>" . $row['acdtime'] . "</td>";
	echo "<td>" . $row['percAux'] . "%</td>";
	echo "</tr>";
	$i++;
}

for ($i; $i < 10; $i++)
{
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "</tr>";
}

echo "</table>";
?>