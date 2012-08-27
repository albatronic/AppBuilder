<?php
global $fechahoybd;
global $fechahoyparaver;
global $horaahorabd;
global $fechahorabd;


$fecha=date(dmY); 
$d=substr($fecha,0,2); 
$m=substr($fecha,2,2); 
$a=substr($fecha,4,4);
$fechahoybd=$a."-".$m."-".$d;
$fechahoyparaver=$d."/".$m."/".$a;


$hora=date(His);
$h=substr($hora,0,2); 
$min=substr($hora,2,2); 
$s=substr($hora,4,2);
$horaahorabd=$h.":".$min.":".$s;

$fechahorabd=$fechahoybd." ".$horaahorabd;

$fecha_numero_largo=$a.$m.$d.$h.$min.$s;

$primerdigito_hora=substr($hora,0,1); 
if($primerdigito_hora=="0"){$digito_hora=substr($hora,1,1);}else{$digito_hora=$h;}


$datetime_ahora=$fechahoybd." ".$horaahorabd;

?>