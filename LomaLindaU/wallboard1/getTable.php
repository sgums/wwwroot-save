<?php

$server = "GPCPDBSP02\M8x5";
$options = array ("UID"=>"SQLVoastAPP", "PWD"=>"Morning*ABC*1", "Database"=>"Voast");
$conn = sqlsrv_connect($server,$options);
//$conn = odbc_connect ('sqlsrv','SQLVoastAPP','Morning*ABC*1');
if ( $conn == false) die ("<pre>" . print_r(sqlsrv_errors(), true));

echo "<table>\n";
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
	
$sql = "exec llu_wb_totals \"$_GET[grp]\"";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$query = sqlsrv_query($conn, $sql, $params, $options);
if ( $query == false )
{
	exit ("<pre>" . print_r (sqlsrv_errors(), true));
}
		
while ($row = sqlsrv_fetch_array($query))
{
	echo "<tr><td>Totals:</td>
		<td>$row[staffed]</td>
		<td>$row[available]</td>
		<td>$row[other]</td>
		<td>$row[waiting]</td>
		<td>$row[oldest]</td>
		<td>$row[svclvl]%</td>
	</tr>\n";
}

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