<html>
<head>
<title>CREAMOS TODAS LAS TABLAS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<?php
echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";
?>

<p><font size="2" face="Arial, Helvetica, sans-serif"> 
<b>SCRIPTS DE CREACIÓN DE TABLAS</b><br><br>
<hr>

<?php

include("tabla_core_perfiles.php");
include("tabla_core_usuarios.php");
include("tabla_core_tiposusuarios.php");
include("tabla_core_aplicaciones.php");
include("tabla_core_tiposfuncionalidad.php");
include("tabla_core_modulos.php");
include("tabla_core_permisos.php");
include("tabla_core_roles.php");
include("tabla_core_urlamigables.php");
include("tabla_core_imagenes.php");


// CREAMOS LA BASE DE DATOS ******************************************************************************
//include("000_bd_crea_user.php");
//include("001_bd_crea_base_datos.php");

/*
include("002_bd_crea_tabla_registromodificaciones.php");
include("003_bd_crea_tabla_contadorvisitas.php");
include("004_bd_crea_tabla_opciones.php");
include("005_bd_crea_tabla_permisos.php");
include("006_bd_crea_tabla_perfilesdeusuarios.php");
include("007_bd_crea_tabla_tiposusuarios.php");
include("009_bd_crea_tabla_versiones.php");
include("010_bd_crea_tabla_visitas.php");
include("011_bd_crea_tabla_t_terceros.php");
include("012_bd_crea_tabla_t_paises.php");
include("013_bd_crea_tabla_t_provincias.php");
include("014_bd_crea_tabla_t_tiposdevias.php");
include("015_bd_crea_tabla_t_vias.php");
include("016_bd_crea_tabla_t_localidades.php");
*/

?>


  </font></p>
  
</body>
</html>
