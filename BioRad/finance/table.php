<?php
include 'vars.php';

$header = "Accounts Receivables";
if ( $_GET['code'] == "AP") {
	$header = "Accounts Payable";
}
	
echo " <table>\n";	
echo "	<tr>
	 <td>$header</td>
	 <td>Calls<br/>Waiting</td>
	 <td>Longest Waiting<br/><span id=\"smallScript\">target: < 20 secs</span></td>	 
	 <td>Calls Lost<br/><span id=\"smallScript\">excls voicemails</span></td>
	 <td>Outgoing Calls</td>
	 <td>Calls<br/>Answered</td>
	 <td>Avg Answer Time<br/><span id=\"smallScript\">target: < 20 secs</span></td>
	</tr>\n";	

$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));
	
//Main Body Data
$sql = "exec finance_center @code=\"$_GET[code]\"";
#echo "<p>$sql</p>\n";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}	
while ($row = sqlsrv_fetch_array($query))
{
	$oldest_secs = $row['oldest_secs'];
	$asa_secs = $row['asa_secs'];
	echo "	<tr>";
	echo "   <td>$row[language]</td>";
	echo "   <td>$row[waiting]</td>";
	if ( $oldest_secs >= 20 )
		echo "   <td id=\"inThreshold\">$row[oldest]</td>";
	else
		echo "   <td>$row[oldest]</td>";

	$offered = $row['offered'];
	$abn = $row['abncalls'];
	if ( $offered > 0 ) {
		$percAbn = 100*(double)($abn/$offered);
		if ( $percAbn >= 5) {
			echo "   <td id=\"inThreshold\">$abn</td>";
		}
		else {
			echo "   <td>$abn</td>";
		}
	}
	else  {
		echo "   <td>$abn</td>";
	}
	echo "   <td>$row[extoutcalls]</td>"
	echo "   <td>$row[acdcalls]</td>";
	if ( $asa_secs >= 20 )
		echo "   <td id=\"inThreshold\">$row[asa]</td>";
	else
		echo "   <td>$row[asa]</td>";
	echo "  </tr>\n";
}

//Totals line
sqlsrv_free_stmt($query);
$sql = "exec finance_totals @code=\"$_GET[code]\"";
#echo "<p>$sql</p>";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}	
	
while ($row = sqlsrv_fetch_array($query))
{
	$oldest_secs = $row['oldest_secs'];
	$asa_secs = $row['asa_secs'];
	echo "	<tr>";
	echo "   <td>$row[name]</td>";
	echo "   <td>$row[waiting]</td>";
	if ( $oldest_secs >= 20 )
		echo "   <td id=\"inThreshold\">$row[oldest]</td>";
	else
		echo "   <td>$row[oldest]</td>";

	$offered = $row['offered'];
	$abn = $row['abncalls'];
	if ( $offered > 0 ) {
		$percAbn = 100*(double)($abn/$offered);
		if ( $percAbn >= 5) {
			echo "   <td id=\"inThreshold\">$abn</td>";
		}
		else {
			echo "   <td>$abn</td>";
		}
	}
	else  {
		echo "   <td>$abn</td>";
	}
	echo "   <td>$row[extoutcalls]</td>"
	echo "   <td>$row[acdcalls]</td>";
	if ( $asa_secs >= 20 )
		echo "   <td id=\"inThreshold\">$row[asa]</td>";
	else
		echo "   <td>$row[asa]</td>";
	echo "  </tr>\n";
}


echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>