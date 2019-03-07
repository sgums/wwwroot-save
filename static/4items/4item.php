<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stanford 4 Items</title>
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

</head>

<body>

<div id="div1" class="auto-style1">
	<font id="headers">Calls Waiting</font><br />
	<?php 

			echo "<font id=\"values\" class=\"inThreshold\">5</font>";  		
			
	?>
</div>
<div id="div2" class="auto-style1">
	<font id="headers">Oldest Call</font><br />
	<?php 
		
			echo "<font id=\"values\" class=\"inThreshold\">2:54</font>"; 
		
	?>
</div>
<div id="div3" class="auto-style1">
	<font id="headers">Agents Available</font><br />
	<?php echo "<font id=\"values\">0</font>"; ?>
</div>
<div id="div4" class="auto-style1">
	<font id="headers">Service Level</font><br />
	
	<?php echo "<font id=\"values\">89.2%</font>"; ?>
</div>

</body>

</html>
