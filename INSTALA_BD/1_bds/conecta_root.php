<?php
function conecta()
{
$db=mysql_connect("localhost","root","");
return $db;
}
?>