<?php
 $grp = $_REQUEST['grp'];
 $updateURL = 'chart_data.php?grp=' . $grp;
?>
<chart>
	<chart_data>
		<row>
			<null/>
			<string>Available</string>
			<string>On Acd</string>
			<string>ACW</string>
			<string>Aux</string>
			<string>Other</string>
		</row>
		<row>
			<string></string>
			<number>20</number>
			<number>20</number>
			<number>20</number>
			<number>20</number>
			<number>20</number>
		</row>
	</chart_data>
	<chart_label shadow='low' alpha='100' size='15' position='inside' as_percentage='false' />
	<chart_pref select='true' drag='false' rotation_x='50' />
	<chart_rect x='10' y='30' width='400' height='200' positive_alpha='0' />
	<chart_type>3d pie</chart_type>
	
	<draw>		
		<rect bevel='bg' layer='background' x='0' y='-10' width='480' height='300' fill_color='fafafa' line_thickness='0' />		
		<text layer='background' shadow='high' color='0' alpha='10' size='80' x='-3' y='205' width='400' height='150'>Summary</text>
		<text layer='background' shadow='low' color='ffffff' alpha='20' rotation='-90' size='75' x='-10' y='235' width='300' height='50' >Agent</text>		
		<!-- <circle layer='background' x='250' y='120' radius='150' fill_alpha='0' line_color='000000' line_alpha='5' line_thickness='65' /> -->
		
	</draw>
	<filter>
		<shadow id='high' distance='3' angle='45' alpha='50' blurX='10' blurY='10' />
		<shadow id='low' distance='2' angle='45' alpha='60' blurX='10' blurY='10' />
		<bevel id='bg' angle='90' blurX='0' blurY='200' distance='50' highlightAlpha='15' shadowAlpha='15' type='inner' />
	</filter>
	
	<legend shadow='low' layout='horizontal' margin='20' x='00' y='-10' width='400' height='35' fill_alpha='0' color='585858' alpha='75' size='10' />
	<update url='<?php print $updateURL ?>' delay='5' mode='data' /> 
	<context_menu full_screen='false' />
	
</chart>