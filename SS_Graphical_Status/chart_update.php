<?php
$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa", "PWD"=>"v0astr00t", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec ss_graph_stat_chart_data \"Operator_Services\"";
$query = sqlsrv_query($conn, $sql);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$avail = 0;
$onacd = 0;
$inacw = 0;
$inaux  = 0;
$other = 0;

while ($row = sqlsrv_fetch_array($query))
{
	$wm = $row['workmode'];
	$wm = trim($wm);
	switch ( $wm ) {
		case 'ACD':
			$onacd = $row['workmode_count'];
			break;
		case 'ACW':
			$inacw = $row['workmode_count'];
			break;
		case 'AVAIL':
			$avail = $row['workmode_count'];
			break;
		case 'AUX':
			$inaux = $row['workmode_count'];
			break;
		case 'OTHER':
			$other = $row['workmode_count'];
			break;
	}
}

echo '<chart>';
echo '   <chart_data>';
echo '      <row>';
echo '         <null/>';
echo '         <string>Available</string>';
echo '         <string>On Acd</string>';
echo '		   <string>Acw</string>';
echo '		   <string>Aux</string>';
echo '		   <string>Other</string>';
echo '      </row>';
echo '      <row>';
echo '         <string></string>';
echo '         <number>' . $avail . '</number>';
echo '         <number>' . $onacd . '</number>';
echo '         <number>' . $inacw . '</number>';
echo '         <number>' . $inaux . '</number>';
echo '         <number>' . $other . '</number>';
echo '      </row>';
echo '   </chart_data>';
echo '   <update url=\'http://localhost/SS_Graphical_Status/chart_update.php\' delay=\'2\' mode=\'data\' />';
echo '</chart>';
?>