
 <?php
include 'vars.php';
if ( !isset($_REQUEST['grp']) )
{
	 echo "<p>No parameter entered</p>";
	 echo "</html>";
	 exit ("");
}
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec teamRpt \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$agentLines = [];
$groupName;

while ($row = sqlsrv_fetch_array($query))
{
	if ( !isset($grpName))
		$groupName = $row['grpName'];
	
	$tableRow = "		<tr>";
	$commaIndex = strpos (trim($row['name']),",");
	$newName = substr(trim($row['name']), 0, ($commaIndex + 3));
	#$tableRow .="<td>" . trim($row['name']) . "</td>";
	$tableRow .="<td>" . $newName . "</td>";
	$workmode = trim($row['workmode']);	
		if ( $workmode == 'NoAUXCodeEntered' )
			$workmode = 'No Code';
		if ( $workmode == "Other 1")
			$workmode = "Outbound";
		$direction = trim($row['direction']);
		if ($direction == 'IN' )
			$direction = ' In';
		elseif ($direction == 'OUT' )
			$direction = ' Out';
		else 
			$direction = '';		
	$tableRow .="<td>". $workmode . $direction . "</td>";
	$tableRow .="<td>" . $row['outbound'] . "</td>";
	$tableRow .="<td>" . $row['acdcalls'] . "</td>";
	$tableRow .="<td>" . $row['rona'] . "</td>";
	$tableRow .= "</tr>";
	$agentLines[] = $tableRow;		
}

echo "<div class=\"teamName\">Team - ". $groupName . "</div>\n";

$leftTable[] ="	<div class=\"leftSide\">";    
$leftTable[] ="		<div class=\"CSSTableGenerator\">";
$leftTable[] ="		<table>";
$leftTable[] ="		<tr><td>Name</td><td>Activity</td><td>Outbound</td><td>Inbound</td><td>RONA</td></tr>";

$rightTable[] =" <div class=\"rightSide\">";    
$rightTable[] ="	<div class=\"CSSTableGenerator\">";
$rightTable[] ="	<table>";
$rightTable[] ="	<tr><td>Name</td><td>Activity</td><td>Outbound</td><td>Inbound</td><td>RONA</td></tr>";

$rowNum = 0;
foreach ($agentLines as $line) {
	$rowNum++;
	if ( $rowNum < 13 ) {
		$leftTable[] = $line;
	}
	else 
	{
		$rightTable[] = $line;
	}	
}
$leftTable[]  = "		</table>\n\t\t</div>\n\t</div>";
$rightTable[] = "		</table>\n\t\t</div>\n\t</div>";

//Now print everything
foreach ($leftTable as $html)
{
	echo $html . "\n";
}
foreach ($rightTable as $html)
{
	echo $html . "\n";
}

?>