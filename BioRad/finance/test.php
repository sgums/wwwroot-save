<?php
include 'vars.php';

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));
	
//Main Body Data
$sql = "exec test \"AR\"";
echo "<p>$sql</p>\n";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}	
while ($row = sqlsrv_fetch_array($query))
{
	
	echo "	<p>$row[name]</p>";
	
}

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>