<?php

$server = "GPCPDBSP02\M8x5";
$options = array ("UID"=>"SQLVoastAPP", "PWD"=>"Morning*ABC*1", "Database"=>"Voast");
$conn = sqlsrv_connect($server,$options);
//$conn = odbc_connect ('sqlsrv','SQLVoastAPP','Morning*ABC*1');
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

$sql = "exec llu_wb_totals \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

$staffed = 0;
$name = "NA";
$available = 0;		
$other = 0;
$waiting = 0;
$oldest= 0;
$svclvl= 0;

while ($row = sqlsrv_fetch_array($query))
{
	$staffed = $row['staffed'];
	$name = $row['name'];
	$available = $row['available'];		
	$other = $row['other'];
	$waiting = $row['waiting'];
	$oldest=$row['oldest'];
	$svclvl=$row['svclvl'];
}

echo "<table>\n";
echo "<tr><td colspan=\"7\">$name Calls Waiting</tr></td>";
echo "<tr><td>Skill</td>
            <td>
                Staffed
            </td>
            <td >
                Available
            </td>
            <td>
                Agents in</br>other skill
            </td>
			<td>
                Calls</br>Waiting
            </td>
			<td>
                Oldest Call</br>Waiting
            </td>			
			<td>
                Service</br>Level
            </td>			
        </tr>\n";	

	echo "<tr><td>Totals:</td>
		<td>$staffed</td>
		<td>$available</td>
		<td>$other</td>
		<td>$waiting</td>
		<td>$oldest</td>
		<td>$svclvl%</td>
	</tr>\n";

sqlsrv_free_stmt($query);	
	
$sql = "exec llu_wb \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr><td>$row[splitname]</td>
		<td>$row[staffed]</td>
		<td>$row[available]</td>
		<td>$row[other]</td>
		<td>$row[waiting]</td>
		<td>$row[oldest]</td>
		<td>$row[svclvl]%</td>
	</tr>\n";
}

echo "</table>\n";
sqlsrv_free_stmt($query);
sqlsrv_close($conn);
?>