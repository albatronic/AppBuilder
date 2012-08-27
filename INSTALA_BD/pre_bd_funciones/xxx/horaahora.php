<?php
global $horaahorabd;

$hora=date(His);
$h=substr($hora,0,2); 
$min=substr($hora,2,2); 
$s=substr($hora,4,2);
$horaahorabd=$h.":".$min.":".$s;

?>