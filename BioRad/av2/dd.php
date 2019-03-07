<?php

include 'vars.php';
$conn = sqlsrv_connect($server,$options);
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

session_start();

if ( !isset($_SESSION["dropdownOptions"]) ) {	
	$sql = "select rtrim(language) as language, rtrim(abbr) as abbr from languages group by language,abbr order by 1";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query($conn, $sql, $params, $options);
	if ( $query == false )
	{
		exit ("<pre>" . print_r (sqlsrv_errors(), true));
	}
	
	$dropdownOptions = [];
	array_push ($dropdownOptions,"\t\t\t<option value=\"NA\">Please Select...</option>\n");
	
	array_push ($dropdownOptions,"\t\t\t<option value=\"NA\">---- Languages ----</option>\n");
	while ($row = sqlsrv_fetch_array($query)) {
		array_push ($dropdownOptions, "\t\t\t<option value=\"lang_$row[abbr]\">$row[language]</option>\n");				
	}
	
	sqlsrv_free_stmt($query);
	$sql = "select rtrim(productLine) as productLine, id from product_lines order by productLine";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query($conn, $sql, $params, $options);
	if ( $query == false )
	{
		exit ("<pre>" . print_r (sqlsrv_errors(), true));
	}
	
	array_push ($dropdownOptions,"\t\t\t<option value=\"NA\">---- Product Lines ----</option>\n");
	while ($row = sqlsrv_fetch_array($query)) {
		array_push ($dropdownOptions,"\t\t\t<option value=\"prod_$row[id]\">$row[productLine]</option>\n");		
	}
	
	sqlsrv_free_stmt($query);
	sqlsrv_close($conn);
	
	$_SESSION["dropdownOptions"] = $dropdownOptions;
}
else
	$dropdownOptions = $_SESSION["dropdownOptions"];
		

echo "<font>Search By:</font>\n";
echo "		<form action=\"\">\n";
echo "			<table>";
echo "			<tr><td><input type=\"radio\" name=\"searchType\" value=\"prod\" onchange=\"handleClick();\">Product Line<br /></td>\n";
echo "			<td><input type=\"radio\" name=\"searchType\" value=\"cust\" onchange=\"handleClick();\">Customer Service<br /></td></tr>\n";
echo "			<tr><td><input type=\"radio\" name=\"searchType\" value=\"lang\" onchange=\"handleClick();\">Language<br /></td>\n";
echo "			<td><input type=\"radio\" name=\"searchType\" value=\"fina\" onchange=\"handleClick();\">Finance AR / AP<br /></td></tr>\n";
echo "			<tr><td colspan=\"2\"><select id=\"Select1\" onchange=\"handleSelect();\">\n";
foreach ($dropdownOptions as $opt) {
	echo $opt;
}
echo "			</select></td></tr>\n";
echo "			<table>";
echo "		</form>\n";

?>