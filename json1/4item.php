<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>4 Items from JSON</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style>
html, body { height: 100%; padding: 0; margin: 0; }
div { width: 50%; height: 50%; float: left; }
#div1 { background: #eeeeee; }
#div2 { background: White; }
#div3 { background: White; }
#div4 { background: #eeeeee; }

#values {
	 font-size:200px;
	 text-shadow: 0 1px 0 #ccc,
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 0 5px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);
}

#headers {
	font-size:50px;	
	/*	text-shadow: 0 1px 0 #ccc,
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 0 5px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);	*/
    color: rgba(10,60,150, 0.8);
    text-shadow: 1px 4px 6px #def, 0 0 0 #000, 1px 4px 6px #def;
}

.auto-style1 {
	text-align: center;
}

.inThreshold{
	color: red; 
	-webkit-animation-name: blinker;
    -webkit-animation-duration: 5s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;	
}

@-webkit-keyframes blinker {  
    0% { opacity: 1.0; }
	40% { opacity: 1.0; }
    50% { opacity: 0.0; }
	60% { opacity : 1.0; }
    100% { opacity: 1.0; }
}

</style>

<?php

function timeToSecs ($str_time) {
	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
	return $time_seconds;
}

function secondsToTime ($seconds)
{
	$time = "0:00";
	$tm = mktime(0, 0, $seconds);
	
	if ( $seconds < 60 ) {
		$time = date(':s', $tm);
	}
	else if ( $seconds < 3600 )
		$time = date('i:s', $tm);
	else
		$time = date('H:i:s', $tm);
	
	return ltrim ($time,"0");
}

function findPercent ($numerator,$demoninator) {
	if ( $demoninator == 0 )
		return 0.0;
	
	return (100*($numerator/$demoninator));
}

$url = "http://localhost:8888/cmsjson/data/$_GET[jsonid]";
$json = file_get_contents($url);
$json = stripslashes($json);
$json = rtrim(ltrim ($json, "\""),"\"");
$obj = json_decode ($json, true);
$data = NULL;

foreach ($obj as $o ){
	$kv = $o['keyValue'];
	if ( $kv == $_GET['spl'] )
	{
		$data = $o['data'];
		break;
	}
}
?>

</head>

<body>

<div id="div1" class="auto-style1">
	<font id="headers">Calls Waiting</font><br />
	<?php 
		$waiting = (int)$data['waiting'];
		if ( $waiting > 5 )		
			echo "<font id=\"values\" class=\"inThreshold\">$waiting</font>";  		
		else		
			echo "<font id=\"values\">$waiting</font>";  		
	?>
</div>
<div id="div2" class="auto-style1">
	<font id="headers">Oldest Call</font><br />
	<?php 
		$oldest = (int)$data['oldest'];
		$oldestDisp = secondsToTime ($oldest);
		if ( $oldest > 300 )
			
			echo "<font id=\"values\" class=\"inThreshold\">$oldestDisp</font>"; 
		else
			echo "<font id=\"values\">$oldestDisp</font>"; 		
	?>
</div>
<div id="div3" class="auto-style1">
	<font id="headers">Agents Available</font><br />
	<?php 
		$available = (int)$data['available'];
		echo "<font id=\"values\">$available</font>"; 
	?>
</div>
<div id="div4" class="auto-style1">
	<font id="headers">Service Level</font><br />	
	<?php
		$svcLvl = round(findPercent($data['acceptable'],$data['offered']), 2);
		echo "<font id=\"values\">$svcLvl%</font>"; 
	?>
</div>
</body>

</html>
