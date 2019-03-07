<?php
$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa","PWD"=>"v0astr00t","Database"=>"cms");
$conn = sqlsrv_connect ($server, $options);

if ( $conn == false) ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec agt_availability \"Operator_Services\"";
$query = sqlsrv_query($conn, $sql);
if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));


$names = "<row>\n\t\t\t<null/>\n";
$auxTime = "<row>\n\t\t\t<string>Aux Time</string>\n";
$talkTime = "<row>\n\t\t\t<string>Talk Time</string>\n";
$availTime = "<row>\n\t\t\t<string>Available</string>\n";

while ($row = sqlsrv_fetch_array($query))
{
		$names .= "\t\t\t<string>" . $row["name"] . "</string>\n";
		$auxTime .= "\t\t\t<number shadow='data' bevel='data'>" . $row["percent_aux"] . "</number>\n";
		$talkTime .= "\t\t\t<number shadow='data' bevel='data'>" . $row["percent_talk"] . "</number>\n";
		$availTime .= "\t\t\t<number shadow='data' bevel='data'>" . $row["percent_avail"] . "</number>\n";		
}

$names .= "\t\t</row>\n";
$auxTime .= "\t\t</row>\n";
$talkTime .= "\t\t</row>\n";
$availTime .= "\t\t</row>\n";

echo "<chart>\n";
echo "\t<chart_data>\n"; 
echo "\t\t" . $names;
echo "\t\t" . $auxTime;
echo "\t\t" . $talkTime;
echo "\t\t" . $availTime;
echo "\t</chart_data>\n"; 
echo "\t<update url='http://localhost/agent_availability/update.php' delay='2' mode='data' />\n";
echo "</chart>\n";


?>