<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>


<p><font size="2" face="Arial, Helvetica, sans-serif"> 
<b>INSTALACIÓN DE LA APLICACIÓN</b><br><br>
<hr>

<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");


include("borrotodaslastablas.php");
include("creatodaslastablas.php");
include("insertoModulos.php");

$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/numero_de_version_inicial.php'; include("$ruta");

//include("numero_de_version_actualizo_bd.php");


?>


  </font></p>
  
</body>
</html>
