<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sonic Top</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<?php
/*
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
*/
?>

</head>

<body>

<div id="top_left" class="top_left auto-style1">
	<font id="headers">Calls Waiting</font><br />
	<font id="values">0</font>
</div>
<div id="top_leftmid" class="top_leftmid auto-style1">
	<font id="headers">Hold Time</font><br />
	<font id="values">00:00:00</font>
</div>
<div id="top_rightmid" class="top_rightmid auto-style1">
	<font id="headers">Service Level</font><br />
	<font id="values">100.0%</font>
</div>
<div id="top_right" class="top_right auto-style1">
	<font id="headers">Agents Staffed</font><br />
	<font id="values">100</font>
</div>
<?php 
/*
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
*/
?>
</body>

</html>