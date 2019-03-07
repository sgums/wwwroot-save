<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec llu_desktop_left \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
		
$row = sqlsrv_fetch_array($query);

echo "	<div class=\"left_top\">
				<font id=\"LeftHeaders\">Answered<br /></font>				
				<font id=\"LeftValues\">$row[acdcalls]</font>
			</div>
			<div class=\"left_middle\">
				<font id=\"LeftHeaders\">Service Level<br /></font>
				<br/>
				<font id=\"LeftValues\">$row[svclvl]%</font>
			</div>
			<div class=\"left_bottom\">
				<font id=\"LeftHeaders\">Calls Waiting<br /></font>
				<br/>
				<font id=\"LeftValues\">$row[waiting]</font>
			</div>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>