<?php
 $split = $_REQUEST['spl'];
 $updateURL = 'chart_data.php?spl=' . $split;
 
 
 $server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa", "PWD"=>"v0astr00t", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec agent_count_chart $_REQUEST[spl]";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($query);


?>
<chart>
	<chart_data>
		<row>
			<null/>
			<string>Available</string>
			<string>On Acd</string>
			<string>Acw</string>
			<string>Aux</string>
			<string>Other</string>
		</row>
		<row>
			<string></string>
			<number><?php print $row['available']?></number>
			<number><?php print $row['onacd']?></number>
			<number><?php print $row['inacw']?></number>
			<number><?php print $row['inaux']?></number>
			<number><?php print $row['other']?></number>
		</row>
	</chart_data>
	
	<update url='<?php print $updateURL ?>' delay='2' mode='data' /> 
	
</chart>
<?php
 sqlsrv_free_stmt($query);
 sqlsrv_close($conn);
?>