<?php

$dblink = mysql_connect("www.interpral.com","interpra_erp","albatronic");
mysql_select_db("interpra_ppuemp",$dblink);

$query = "select * from empresas";
$result = mysql_query($query,$dblink);
while ($row = mysql_fetch_assoc($result))
    echo $row['RazonSocial'],"<br />";

mysql_close($dblink);
?>
