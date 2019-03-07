<?php
echo '<chart>';
echo '   <chart_data>';
echo '      <row>';
echo '         <null/>';
echo '         <string>Available</string>';
echo '         <string>On Acd</string>';
echo '		   <string>Acw</string>';
echo '		   <string>Aux</string>';
echo '		   <string>Other</string>';
echo '      </row>';
echo '      <row>';
echo '         <string></string>';
echo '         <number>' . rand(1,15) . '</number>';
echo '         <number>' . rand(1,30) . '</number>';
echo '         <number>' . rand(1,10) . '</number>';
echo '         <number>' . rand(1,15) . '</number>';
echo '         <number>' . rand(1,10) . '</number>';
echo '      </row>';
echo '   </chart_data>';
echo '   <update url=\'http://www.voast.com/scala/Demo/chart_update.php\' delay=\'5\' mode=\'data\' />';
echo '</chart>';
?>