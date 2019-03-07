
 <?php
include 'vars.php';
if ( !isset($_REQUEST['spl']) )
{
	 echo "<p>No parameter entered</p>";
	 echo "</html>";
	 exit ("");
}
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec ss_graph_stat_agt_bysplit \"$_GET[spl]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row_count = sqlsrv_num_rows( $query );
$max_rows = 10;
$total_pages = ceil($row_count / $max_rows);
$current_page = 1;

session_start();
if ( $row_count > 0 )
{
	if ( isset ($_SESSION['page_num'] ) ) {
		$current_page = $_SESSION['page_num'];
	}
	else {
		$current_page = 1;
	}
	
	if ( $current_page > $total_pages ) {
		$current_page = $total_pages;
	}
	
	if ( $current_page < 1 ) {
		$current_page = 1;
	}
}
else {
	echo "<p>No rows found</p>";
	exit (0);
}

echo "<table>";

$range_start = ($current_page -1 ) * $max_rows;
$range_stop = $range_start + $max_rows;

while ($row = sqlsrv_fetch_array($query))
{
	$row_number = $row['rowNumber'];
	if ( $row_number > $range_start and $row_number <= $range_stop )
	{
		echo "<tr>";
		echo "<td width=\"32%\">" . trim($row['name']) . "</td>";
		$workmode = trim($row['workmode']);	
		if ( $workmode == 'NoAUXCodeEntered' )
			$workmode = 'No Aux Code';
		if ( $workmode == "Other 1")
			$workmode = "Outbound";
		$direction = trim($row['direction']);
		if ($direction == 'IN' )
			$direction = ' In';
		elseif ($direction == 'OUT' )
			$direction = ' Out';
		else 
			$direction = '';
		echo "<td width=\"170px\">" . $workmode . $direction ."</td>";
		$duration_seconds = $row['duration_seconds'];
		$duration = $row['duration'];
		/*
		Test for the thresholds on duration
		*/			
		$inThreshold = false;
		
		if ( $workmode == 'No Aux Code' and $duration_seconds > 3600 )
			$inThreshold = true;
			
		
		echo "<td width=\"113px\">";
			if( $inThreshold )
				echo "<font class=\"inThreshold\">" . $duration . "</font>";
			else
				echo $duration;				
		echo "</td>";
		
		$worksplit = $row['worksplit'];
		$worksplit = trim($worksplit);
		if ( $worksplit == '0') {
				echo "<td width=\"190px\"> - </td>";
				//echo "<td></td>";	
		}
		else {
			echo "<td width=\"245px\">" . trim($row['worksplit']) . "</td>";
			//echo "<td>" . $row['skill_level'] . "</td>";
		}
		echo "</tr>";
	}
}

	$current_page++;
	if ( $current_page > $total_pages ) {
		$current_page = 1;
	}
	$_SESSION['page_num'] = $current_page;

echo "</table>";
?>