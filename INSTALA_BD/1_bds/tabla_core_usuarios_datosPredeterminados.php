<?php

$dato=$Campo1[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Login="'".$dato."'";


$dato=$Campo2[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Password="'".md5($dato.$variableadmin_semillamd5)."'";

$dato=$Campo3[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$IDPerfil="'".$dato."'";


$dato=$Campo4[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$IDTipoUsuario="'".$dato."'";


$dato=$Campo5[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$IDRol="'".$dato."'";


$dato=$Campo6[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Nombre="'".$dato."'";


$dato=$Campo7[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Apellidos="'".$dato."'";

?>