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

$sql = "exec inAuxCount \"$_GET[spl]\"";
$query = sqlsrv_query($conn, $sql);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$inaux1 = 0;
$inaux2 = 0;
$inaux3 = 0;
$inaux4 = 0;
$inaux5 = 0;
$inaux6 = 0;
$inaux7 = 0;

while ($row = sqlsrv_fetch_array($query))
{
	$inaux1 = $row['inaux1'];
	$inaux2 = $row['inaux2'];
	$inaux3 = $row['inaux3'];
	$inaux4 = $row['inaux4'];
	$inaux5 = $row['inaux5'];
	$inaux6 = $row['inaux6'];
	$inaux7 = $row['inaux7'];
}

//Other removed from end.
$data = array ($inaux1, $inaux2, $inaux3, $inaux4, $inaux5, $inaux6, $inaux7 );
echo json_encode($data);
?>