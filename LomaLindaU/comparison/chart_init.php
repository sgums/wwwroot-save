<?php
$date_array = getdate();
session_start();
unset($_SESSION["currentDate"]);

include 'vars.php';
$conn = sqlsrv_connect ($server, $options);
if ( $conn == false) ("<pre>" . print_r(sqlsrv_errors(), true));

$grp = $_REQUEST['grp'];
$sql = "select distinct display_name from split_groups where param='" . $grp . "';";
$query = sqlsrv_query($conn, $sql);

if ( $query == false) exit ("<pre>" . print_r (sqlsrv_errors(), true));
if (sqlsrv_fetch ($query) == false ) {
	die (print_r (sqlsrv_errors(), true));
}

$dispName = sqlsrv_get_field($query,0);
$header = $dispName . " - Calls Offered";
if ( $dispName == "Operations") {
	$header = "All Calls Offered";
}

	
?>
<chart>
	<axis_category shadow='light' size='7' color='000000' alpha='90' orientation='diagonal_up' skip='1' />	
	<axis_value shadow='light' size='10' color='000000' alpha='90' steps='4' prefix='' suffix='' decimals='0' separator='' show_min='true' />	
	<chart_border color='000000' top_thickness='0' bottom_thickness='2' left_thickness='0' right_thickness='0' />
	<chart_data>
		<row>
			<null/>
			<string>7:00</string>			
			<string>7:30</string>			
			<string>8:00</string>
			<string>8:30</string>
			<string>9:00</string>
			<string>9:30</string>
			<string>10:00</string>
			<string>10:30</string>
			<string>11:00</string>
			<string>11:30</string>
			<string>12:00</string>
			<string>12:30</string>
			<string>13:00</string>
			<string>13:30</string>
			<string>14:00</string>
			<string>14:30</string>
			<string>15:00</string>
			<string>15:30</string>
			<string>16:00</string>
			<string>16:30</string>
			<string>17:00</string>
		</row>
		<row>
			<string>Last Ten <?php print $date_array['weekday'] ?>150</string>

			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>
			<number bevel='bevel1' shadow='high'>50</number>			
		</row>
		<row>
			<string>Today</string>
			<number bevel='bevel1'>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>
			<number>40</number>							
		</row>
	</chart_data>
	<chart_grid_h alpha='20' color='000000' thickness='1' type='dashed' />
	<chart_label color='000000' alpha='60' size='9' position='below' />
	<chart_pref line_thickness='2' point_shape='circle' fill_shape='true' />
	<chart_rect x='00' y='35' width='425' height='190' positive_alpha='0' />
	<chart_type>
		<string>column</string>
		<string>line</string>
	</chart_type>

	<draw>
		<rect shadow='bg' layer='background' x='0' y='0' width='480' height='300' fill_color='0' />
		<!-- <text shadow='low' layer='background' color='0' alpha='7' rotation='-5' size='100' x='110' y='85' width='300' height='200'>up</text> -->
		<text shadow='low' color='000000' alpha='10' rotation='-90' size='35' x='-50' y='300' width='400' height='200' >||||||||||||||||||||||||||||||</text>
		<text shadow='high' color='000000' alpha='90' size='25' x='-15' y='-5' width='480' height='200' h_align='center'><?php print $header ?></text>
	</draw>
	<filter>
		<shadow id='low' distance='2' angle='45' color='0' alpha='50' blurX='5' blurY='5' />
		<shadow id='high' distance='7' angle='45' color='0' alpha='40' blurX='15' blurY='15' />
		<shadow id='bg' inner='true' quality='1' distance='50' angle='135' color='000000' alpha='10' blurX='300' blurY='200' knockout='true' />
		<bevel id='bevel1' angle='0' blurX='10' blurY='0' distance='5' highlightAlpha='15' highlightColor='ffffff' shadowAlpha='15' type='inner' />
	</filter>
	<!--
	<legend shadow='low' x='130' y='58' width='200' height='40' margin='5' fill_color='000000' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' bullet='circle' size='11' color='000000' alpha='60' />
	-->
	<legend bullet='circle' y='20' width='20' size='8' x='0' />
	
	<series_color>
		<color>ffee88</color>
		<color>0000ff</color>
	</series_color>
	
	<update url='data.php?grp=<?php print $_REQUEST['grp'] ?>' delay='4' mode='data' />
	
</chart>
