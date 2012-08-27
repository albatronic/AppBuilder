<?php

$dato=$Campo1[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Codigo="'".$dato."'";


$dato=$Campo2[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Titulo="'".$dato."'";


$dato=$Campo3[$indice];
//$dato=strtoupper($dato);
$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
$ruta = 'tratamientoDeCadenas.php'; include("$ruta");

$Descripcion="'".$dato."'";




?>