<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$grp = $_REQUEST['grp'];
$sql = "select distinct display_name from split_groups where param='" . $grp . "';";
$query = sqlsrv_query($conn, $sql);

if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));
if (sqlsrv_fetch ($query) == false ) {
	die (print_r (sqlsrv_errors(), true));
}

$dispName = sqlsrv_get_field($query,0);
echo "$dispName";
?>