<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$filter = $_GET['filter'];

$prod = 0;
$lang = "NA";  //default to en
$custa = "__";
$finance = "__";

if ( substr($filter,0,4) == "prod" ) {
	$prod = substr($filter, 5,2);	
}//if it is search for Prof
elseif ( substr($filter,0,4) == "lang" ) {
	$lang = substr($filter, 5);
}
elseif ( substr($filter,0,4) == "cust" ) {
	$custa = "CA%";
}
else if ( substr ($filter, 0,4) == "fina" ) {
	$finance = "FSSC%";
}

//For Debugging
echo "<p>Filter=" . $filter . " Lang=" . $lang . " Prod=" . $prod . " Adv=" . $custa . " Fin=" . $finance . "</p>"; 

	$sql = "execute av_filtered @lang=\"$lang\",@prod=$prod, @advocates=\"$custa\", @finance=\"$finance\"";
	//echo "<p>$sql</p>";  //For debugging
	
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query($conn, $sql, $params, $options);
	if ( $query == false )
	{
		exit ("<pre>" . print_r (sqlsrv_errors(), true));
	}
	
	echo " <table>\n";	
	echo "	 <tr><td>Split</td><td>Staffed</td><td>Avail</td></tr>\n";
	
	while ($row = sqlsrv_fetch_array($query)) {
		echo "	 <tr><td class=\"tooltip\">$row[displayName]<span class=\"tooltiptext\">VDN:$row[vdn]</span></td><td>$row[staffed]</td><td>$row[available]</td></tr>\n";		
	}
echo " </table>\n";

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>