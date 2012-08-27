<?php
if($permiso_insert=="SI"){ 

$_SESSION['controlinsert']=0;

$tituloCuadroDialogo=$variablesubmodulo_titulo_dialogo_nuevo; $textoCuadroDialogo=$variablesubmodulo_mensaje_dialogo_nuevo; 
$imagenBoton1="btn_cancelar.jpg"; $titleBoton1="Cancelar"; $urlBoton1="index.php?g=1&amp;f=$f&amp;f1=$f1"; 
$imagenBoton2="btn_aceptar2.jpg"; $titleBoton2="Aceptar"; $urlBoton2="index.php?g=1&amp;f=$f&amp;f1=$f1&amp;s1=0_formulario&amp;action=ins&f_Padre=".$f_Padre."&f1_Padre=".$f1_Padre."&md5_Padre=".$md5_Padre."&copio_Padre=".$copio_Padre; 


		$ruta = $variableadmin_prefijo_bd.'0_api/cuadroDialogo250Texto.php'; include("$ruta");
}
?>