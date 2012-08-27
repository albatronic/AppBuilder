<?php

$year_decode=substr($fechahora_problema,0,4); 
$mes_decode=substr($fechahora_problema,5,2); 
$dia_decode=substr($fechahora_problema,8,2);

$hour_decode=substr($fechahora_problema,11,2); 
$minute_decode=substr($fechahora_problema,14,2); 
$second_decode=substr($fechahora_problema,17,8); 

$hora_decode=substr($fechahora_problema,11,8); 


$fecha_decode=$dia_decode."/".$mes_decode."/".$year_decode;

$fecha_hora_decode=$dia_decode."/".$mes_decode."/".$year_decode." - ".$hora_decode;

$fecha_hora_decode_v2=$dia_decode."/".$mes_decode."/".$year_decode." ".$hora_decode;

if($year_decode=="0000"){$year_decode="";}
if($dia_decode=="00"){$dia_decode="";}
?>