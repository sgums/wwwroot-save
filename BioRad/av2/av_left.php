<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$filter = $_GET['filter'];

$prod = 0;
$lang = "en";  //default to en

if ( substr($filter,0,4) == "prod" ) {
	$prod = substr($filter, 5,2);	
}//if it is search for Prof
elseif ( substr($filter,0,4) == "lang" ) {
	$lang = substr($filter, 5,2);
}

//For Debugging
//echo "<p>Filter=" . $filter . " Lang=" . $lang . " Prod=" . $prod . "</p>";

	$sql = "execute av_left @lang=\"$lang\",@prod=$prod";
	//echo "<p>$sql</p>";  //For debugging
	
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query($conn, $sql, $params, $options);
	if ( $query == false )
	{
		exit ("<pre>" . print_r (sqlsrv_errors(), true));
	}
	
	if( sqlsrv_fetch( $query ) === false) {
     die( print_r( sqlsrv_errors(), true));
	}
	
	$waiting = sqlsrv_get_field ($query,0);
	$oldest_secs = sqlsrv_get_field ($query,1);
	$oldest = sqlsrv_get_field ($query,2);
	$acdcalls = sqlsrv_get_field ($query,3);
	echo  "<div class=\"left1\" ><font id=\"mainHeader\">Waiting</font><br/><font id=\"mainValues\">$waiting</font></div>\n";
	echo  "<div class=\"left1\" ><font id=\"mainHeader\">Longest</font><br/><font id=\"mainValues\">$oldest</font></div>\n";
	echo  "<div class=\"left1\" ><font id=\"mainHeader\">Answered</font><br/><font id=\"mainValues\">$acdcalls</font></div>\n";	

sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>