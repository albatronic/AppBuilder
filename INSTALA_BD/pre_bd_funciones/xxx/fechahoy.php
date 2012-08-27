<?php
global $fechahoybd;
global $fechahoyparaver;

$fecha=date(dmY); 
$d=substr($fecha,0,2); 
$m=substr($fecha,2,2); 
$a=substr($fecha,4,4);
$fechahoybd=$a."-".$m."-".$d;
$fechahoyparaver=$d."/".$m."/".$a;

?>