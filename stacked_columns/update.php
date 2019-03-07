<?php
$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa","PWD"=>"v0astr00t","Database"=>"cms");
$conn = sqlsrv_connect ($server, $options);

if ( $conn == false) ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec agt_availability \"Operator_Services\"";
$query = sqlsrv_query($conn, $sql);
if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));


$names = '<row><null/>';
$auxTime = '<row><string>Aux Time</string>';
$talkTime = '<row><string>Talk Time</string>';
$availTime = '<row><string>Available Time</string>';

while ($row = sqlsrv_fetch_array($query))
{
		$names .= '<string>' . $row['name'] . '</string>';
		$auxTime .= '<number shadow=\'data\' bevel=\'data\'>' . $row['percent_aux'] . '</number>';
		$talkTime .= '<number shadow=\'data\' bevel=\'data\'>' . $row['percent_talk'] . '</number>';
		$availTime .= '<number shadow=\'data\' bevel=\'data\'>' . $row['percent_avail'] . '</number>';		
}

$names .= "</row>\n";
$auxTime .= "</row>\n";
$talkTime .= "</row>\n";
$availTime .= "</row>\n";

echo "<chart>\n";
echo "\t<chart_data>\n"; 
echo "\t\t" . $names;
echo "\t\t" . $auxTime;
echo "\t\t" . $talkTime;
echo "\t\t" . $availTime;
echo "\t</chart_data>\n"; 
echo "</chart>\n"
?>