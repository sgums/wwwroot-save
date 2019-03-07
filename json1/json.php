<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>JSON</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<body>
<h1>JSON Testing</h1>
<?php

$url = "http://localhost:8888/cmsjson/data/1";
$json = file_get_contents($url);
$json = stripslashes($json);
$json = rtrim(ltrim ($json, "\""),"\"");
$obj = json_decode ($json, true);

echo "<p>";
//echo "count is " . count ($obj) . "<br />";

/*
for ($i =0; $i < count($obj); $i++ )
{		
	var_dump ($obj[$i]);
	echo "<br /><br />";
}
*/

foreach ($obj as $o ){
	$kv = $o['keyValue'];
	if ( $kv == 2 )
	{
		echo "TA DA Found it<br /><br />";
		
		$data = $o['data'];
		echo "Object Type:" . gettype ($data) . "<br />";
		echo "Split: " . $data['splitname'] . "<br />";
		echo "Calls Offered: " . (int)$data['offered'] . "<br />";
		echo "ACD Calls: " . (int)$data['acdcalls'] . "<br />";
		echo "On ACD: " . (int)$data['onacd'] . "<br />";
		echo "Oldest: " . (int)$data['oldest'] . "<br />";
		
		var_dump ($data);
		break;
	}
	else {
		echo "Key: " . $kv . "<br />";
	}
	
}

//echo "Object Type:" . gettype ($obj) . "<br />";
//var_dump ($obj);
echo "</p>";



?>

</body>

</html>