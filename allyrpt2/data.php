<?php
include 'vars.php';
if ( !isset($_REQUEST['spl']) )
{
	 echo "<p>No parameter entered</p>";
	 echo "</html>";
	 exit ("");
}
$spl = $_REQUEST['spl'];
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec ss_graph_stat_chart_data \"$_GET[spl]\"";
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

//Other removed from end.
$data = array ($avail, $onacd, $inacw, $other, $inaux  );
echo json_encode($data);
?>