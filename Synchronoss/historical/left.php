<chart>
	<chart_data>
		<row>
			<null/>
			<string>Answered</string>
			<string>Abandon</string>			
		</row>
		<row>
			<string></string>
			<number>1</number>
			<number>1</number>
		</row>
	</chart_data>
	<chart_label shadow='low' alpha='100' size='24' position='inside' as_percentage='false' />
	<chart_pref select='true' drag='false' rotation_x='50' />
	<chart_rect x='80' y='10' width='225' height='225' positive_alpha='0' />
	<chart_type>3d pie</chart_type>
	
	<draw>		
		<rect bevel='bg' layer='background' x='0' y='0' width='480' height='300' fill_color='f2f2f2' line_thickness='0' />		
		<text layer='background' shadow='high' color='0' alpha='40' size='48' x='-3' y='205' width='500' height='150'>OMC 1/9</text>
		<circle layer='background' x='250' y='120' radius='200' fill_alpha='0' line_color='000000' line_alpha='5' line_thickness='65' />
	</draw>
	<filter>
		<shadow id='high' distance='3' angle='45' alpha='50' blurX='10' blurY='10' />
		<shadow id='low' distance='2' angle='45' alpha='60' blurX='10' blurY='10' />
		<bevel id='bg' angle='90' blurX='0' blurY='200' distance='50' highlightAlpha='15' shadowAlpha='15' type='inner' />
	</filter>
	
	<legend shadow='low' layout='horizontal' margin='20' x='10' y='-10' width='400' height='25' fill_alpha='0' color='000000' alpha='75' size='16'/>
	<context_menu full_screen='false' />
</chart>