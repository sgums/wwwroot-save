 <?php
 include 'vars.php';
 
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec ss_graph_stat_agt_bygrp \"$_REQUEST[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

echo "<table>";


while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr>";
		echo "<td width=\"45%\">" . trim($row['name']) . "</td>";
		$workmode = trim($row['workmode']);		
		/* echo "<td width=\"170px\">" . $workmode ."</td>"; */
		echo "<td width=\"170px\">ACW</td>";
		$duration_seconds = $row['duration_seconds'];
		$duration = $row['duration'];
		
		//Test for the thresholds on duration
				
		$inThreshold = false;
		/* Not yet
		if ( $workmode == 'On ACD' and $duration_seconds > 480 )
			$inThreshold = true;
		if ( $workmode == 'Lunch' and $duration_seconds > 1800 ) //1800
			$inThreshold = true;
		if ( $workmode == 'Break' and $duration_seconds > 900 ) //900
			$inThreshold = true;
		*/
		
		echo "<td width=\"113px\">";
			if( $inThreshold )
				echo "<font class=\"inThreshold\">" . $duration . "</font>";
			else
				echo $duration;				
		echo "</td>";
		
		/*
		$worksplit = $row['worksplit'];
		$worksplit = trim($worksplit);
		if ( $worksplit == '0') {
				echo "<td width=\"190px\"> - </td>";
				echo "<td></td>";	
		}
		else {
			echo "<td width=\"245px\">" . trim($row['worksplit']) . "</td>";
			echo "<td>" . $row['skill_level'] . "</td>";
		}
		*/
		
	echo "</tr>";
}

echo "</table>";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>