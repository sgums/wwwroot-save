<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Tenant CMS Desktop</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style>
html, body { height: 100%; padding: 0; margin: 0; }
div.auto-style1 { 
	width: 33%; 
	height: 45%;
	float: left; 
}

div.auto-style2 { 
	width: 100%; 
	height: 15%;
	float: left; 
	text-align: center;
}

div.auto-style3 { 
	width: 25%; 
	height: 40%;
	float: left; 
	text-align: center;
}

.auto-style1 {
	text-align: center;
}

#div1 { background: #eeeeee; }
#div2 { background: White; }
#div3 { background: #eeeeee; }
#div4 { background: #eeeeee; }
#div5 { background: #bed0e2; }
#div6 { background: #eeeeee; }
#div7 { background: White; }
#div8 { background: #eeeeee; }
#div9 { background: White; }

#values {
	 font-size:75px;
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
	font-size:20px;	
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

#centeredHeaders {
	font-size:30px;	
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
$server = "localhost\SQLEXPRESS";
$options = array("UID" => "sa",  "PWD" => "v0astr00t",  "Database" => "tester");
$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));

$sql = "exec fourItemsSP $_GET[spl]";
$query = sqlsrv_query($conn, $sql);
if ($query === false)
{  
	exit("<pre>".print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($query);
?>

</head>

<body>

<div id="div1" class="auto-style1">
	<font id="headers">Calls Waiting</font><br />
	<?php 
		$waiting = $row['Waiting'];
		if ( $waiting > 5 )		
			echo "<font id=\"values\" class=\"inThreshold\">$row[Waiting]</font>";  		
		else		
			echo "<font id=\"values\">$row[Waiting]</font>";  		
	?>
</div>
<div id="div2" class="auto-style1">
	<font id="headers">Oldest Call</font><br />
	<?php 
		if ( $row['oldest_ss'] > 300 )
			echo "<font id=\"values\" class=\"inThreshold\">$row[Oldest]</font>"; 
		else
			echo "<font id=\"values\">$row[Oldest]</font>"; 		
	?>
</div>
<div id="div3" class="auto-style1">
	<font id="headers">Avg Speed Ans</font><br />
	<?php echo "<font id=\"values\">$row[Oldest]</font>"; ?>
</div>
<div id="div5" class="auto-style2">
	<font id="centeredHeaders">Agents</font></div>	
</div>
<div id="div6" class="auto-style3">
	<font id="headers">Staffed</font><br />
	<?php
		$svclvl = preg_replace ("/\.0/","",$row['Service_Level']);
	?>
	<?php echo "<font id=\"values\">100</font>"; ?>
</div>
<div id="div7" class="auto-style3">
	<font id="headers">ACD</font><br />
	<?php
		$svclvl = preg_replace ("/\.0/","",$row['Service_Level']);
	?>
	<?php echo "<font id=\"values\">10</font>"; ?>
</div>
<div id="div8" class="auto-style3">
	<font id="headers">Aux Work</font><br />
	<?php
		$svclvl = preg_replace ("/\.0/","",$row['Service_Level']);
	?>
	<?php echo "<font id=\"values\">10</font>"; ?>
</div>
<div id="div9" class="auto-style3">
	<font id="headers">Unavailable</font><br />
	<?php
		$svclvl = preg_replace ("/\.0/","",$row['Service_Level']);
	?>
	<?php echo "<font id=\"values\">10</font>"; ?>
</div>
<?php 
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>
</body>

</html>
