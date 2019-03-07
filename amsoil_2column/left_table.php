<?php

$server = "localhost\SQLEXPRESS";
$options = array ("UID"=>"sa", "PWD"=>"v0astr00t", "Database"=>"cms");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec amsoil_left_table $_GET[spl]";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

//echo "<table class=\"CSSTableData\">\n";

while ($row = sqlsrv_fetch_array($query))
{
	echo "\t<tr class=\"data\">";
		echo "<td class=\"data\" width=\"200px\">" . trim($row['name']) . "</td>";
		$workmode = trim($row['workmode']);		
		echo "<td class=\"data\" width=\"150px\">" . $workmode ."</td>";
		$duration_seconds = $row['duration_seconds'];
		$duration = $row['duration'];
		/*
		Test for the thresholds on duration
		*/			
		$inThreshold = false;
		if ( $workmode == 'On ACD' and $duration_seconds > 480 )
			$inThreshold = true;
		if ( $workmode == 'Lunch' and $duration_seconds > 1800 ) //1800
			$inThreshold = true;
		if ( $workmode == 'Break' and $duration_seconds > 900 ) //900
			$inThreshold = true;
			
		echo "<td class=\"data\" width=\"150px\">" . $row['aux_reason'] . "</td>";
		
		echo "<td class=\"data\" width=\"100px\">";
			if( $inThreshold )
				echo "<font class=\"inThreshold\">" . $duration . "</font>";
			else
				echo $duration;				
		echo "</td>";
							
	echo "</tr>\n";
}

//echo "</table>";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>