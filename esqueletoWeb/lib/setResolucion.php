<?php

/*
 * PONGO LA RESOLUCION DEL NAVEGADOR DEL CLIENTE EN
 * UNA VARIABLE DE ENTORNO PARA QUE SEA USADA POR EL
 * CONTROLADOR DE VISITAS
 * 
 * ESTE SCRIPT ES LLAMADO VIA AJAX POR LA FUNCION 'js/AEscripts.js chequeaResolucionVisitante'
 */
session_start();
$_SESSION['resolucionVisitante'] = $_POST['resolucion'];
?>
