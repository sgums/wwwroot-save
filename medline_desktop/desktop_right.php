<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec medline_desktop_right \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
		
$row = sqlsrv_fetch_array($query);

echo "	<div class=\"right_top\">
				<font id=\"RightHeaders\">Calls Offered</font>
				<br/><br/>
				<font id=\"RightValues\">$row[acdcalls]</font>
			</div>
			<div class=\"right_middle\">
				<font id=\"RightHeaders\">Calls Abandon</font>
				<br/><br/>
				<font id=\"RightValues\">$row[svclvl]</font>
			</div>
			<div class=\"right_bottom\">
				<font id=\"RightHeaders\">Calls Waiting</font>
				<br/><br/>
				<font id=\"RightValues\">$row[waiting]</font>
			</div>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>