<?php

$sql="drop table $tabla";
if (mysql_query($sql,$db)){
echo "BORRADA LA TABLA <b>$tabla</b><br>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO BORRAR LA TABLA <b>$tabla</b></font><br>";
}

?>