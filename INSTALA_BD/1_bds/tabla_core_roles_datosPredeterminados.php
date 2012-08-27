<?php

$dato=$Campo1[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Rol="'".$dato."'";
//echo "TipoUsuario: ",$TipoUsuario,"<br>";
?>