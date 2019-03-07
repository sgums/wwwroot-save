<?php

$grp = $_REQUEST['grp'];
$updateURL = 'chart_update.php?grp=' . $grp;
 
include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec graphStatGrp_chart \"$_GET[grp]\"";
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

if ( $avail == 0 and $onacd == 0 and $inacw == 0 and 
		$inaux == 0 and $other == 0 ) {
	$avail = 1;
	$onacd = 1;
	$inacw = 1;
	$inaux  = 1;
	$other = 1;
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
echo '   <update url=\'' . $updateURL . '\' delay=\'4\' mode=\'data\' />';
echo '</chart>';
?>