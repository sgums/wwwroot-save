<?php
 $grp = $_REQUEST['grp'];
 $updateURL = 'chart_data.php?grp=' . $grp;
 
 
include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec agent_count_chart $_REQUEST[grp]";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($query);

$available = 1;
$onacd = 1;
$inacw = 1;
$inaux = 1;
$other = 1;

$row_count = sqlsrv_num_rows($query);
if ( $row_count > 0) {
	$available = $row['available'];
	$onacd = $row['onacd'];
	$inacw = $row['inacw'];
	$inaux = $row['inaux'];
	$other = $row['other'];
}

if ( $available == 0 and $onacd == 0 and 
	$inacw == 0 and $inaux == 0 and $other == 0) {
	$available = 1;
	$onacd = 1;
	$inacw = 1;
	$inaux = 1;
	$other = 1;
}

?>
<chart>
	<chart_data>
		<row>
			<null/>
			<string>Available</string>
			<string>On Acd</string>
			<string>ACW</string>
			<string>Aux</string>
			<string>Other</string>
		</row>
		<row>
			<string></string>
			<number><?php print $available ?></number>
			<number><?php print $onacd ?></number>
			<number><?php print $inacw ?></number>
			<number><?php print $inaux ?></number>
			<number><?php print $other ?></number>
		</row>
	</chart_data>
	
	<update url='<?php print $updateURL ?>' delay='5' mode='data' /> 
	
</chart>
<?php
 sqlsrv_free_stmt($query);
 sqlsrv_close($conn);
?>