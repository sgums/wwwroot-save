<?php

include 'dbinfo.php';

$grp = $_REQUEST['grp'];
$subGroup = $_REQUEST['sgrp'];
$updateURL = 'chart_data.php?sgrp=' . $subGroup . '&grp=' . $grp;
$updateURL = str_replace(" ","%20", $updateURL);

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec sync_hist_chart @grpName=\"$grp\", @subGroupName=\"$subGroup\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row= sqlsrv_fetch_array($query);
?>
<chart>
	<chart_data>
		<row>
			<null/>
			<string>Answered</string>
			<string>Abandon</string>			
		</row>
		<row>
			<string></string>
			<number><?php print $row['acdcalls']; ?></number>
			<number><?php print $row['abncalls']; ?></number>
		</row>
	</chart_data>	
	<update url='<?php print $updateURL; ?>' delay='3' mode='data' />
</chart>
<?php
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>