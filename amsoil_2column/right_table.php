<?php

$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa", "PWD"=>"v0astr00t", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec amsoil_right_table $_GET[spl]";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($query);

echo "			<div class=\"middleTopLeftHalf center\">\n";
echo "				<font id=\"headers\">Waiting</font><br />\n";
echo "				<font id=\"values\">$row[waiting]</font>\n";
echo "			</div>\n";
echo "			<div class=\"middleTopRightHalf center\">\n";
echo "				<font id=\"headers\">Available</font>\n";
echo "				<br />\n";
echo "			<font id=\"values\">$row[available]</font>\n";
echo "			</div>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>