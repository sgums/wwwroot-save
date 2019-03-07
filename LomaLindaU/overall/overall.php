<?php

$server = "GPCPDBSP02\M8x5";
$options = array ("UID"=>"SQLVoastAPP", "PWD"=>"Morning*ABC*1", "Database"=>"Voast");
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec overall $_GET[grp]";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($query);

echo "	<div class=\"left\">\n";
echo "	   <div class=\"top\">\n";
echo "	    <font id=\"headers\">Calls Answered</font></br>\n";
echo "		<font id=\"Values\">$row[acdcalls]</font>\n";
echo "	   </div>\n";
echo "	  <div class=\"middle\">\n";
echo "	    <font id=\"headers\">Service Level</font></br>\n";
$svcLvl = $row['svclvl'];
if ( $svcLvl > 80 )
	echo "		<font id=\"Values\">$svcLvl%</font>\n";
else
	echo "		<font id=\"Values\" class=\"inThreshold\">$svcLvl%</font>\n";
echo "	  </div>\n";
echo "	  <div class=\"bottom\">\n";
echo "	    <font id=\"headers\">Calls Waiting</font></br>\n";
echo "		<font id=\"Values\">$row[waiting]</font>\n";
echo "	  </div>\n";
echo "	 </div>\n";
echo "	 <div class=\"right\">\n";
echo "	  <div class=\"top\">\n";
echo "	    <font id=\"headers\">Oldest Call</font></br>\n";
echo "		<font id=\"Values\">$row[oldest]</font>\n";
echo "	   </div>\n";
echo "	  <div class=\"middle\">\n";
echo "	    <font id=\"headers\">Average ACD Time</font></br>\n";
echo "		<font id=\"Values\">$row[att]</font>\n";
echo "	  </div>\n";
echo "	  <div class=\"bottom\">\n";
echo "	    <font id=\"headers\">% Calls Abandons</font></br>\n";
$percAbn = $row['perc_abn'];
if ( $percAbn < 5 )
	echo "		<font id=\"Values\">$percAbn%</font>\n";
else
	echo "		<font id=\"Values\" class=\"inThreshold\">$percAbn%</font>\n";
echo "	  </div>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);


?>