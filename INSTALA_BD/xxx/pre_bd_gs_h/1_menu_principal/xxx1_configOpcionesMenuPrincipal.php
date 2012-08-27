<?php
switch($id_opcion){

case "2": $imagen_icono="ico_ayudadomicilio.jpg"; 
			$f_destino=$variableadmin_prefijo_bd.'gs_ad'; 
			$enlace_opcion="index.php?g=1&amp;f=$f_destino";
			break;


case "4": $imagen_icono="ico_terceros.jpg"; 
			$f_destino=$variableadmin_prefijo_bd.'gs_t'; 
			$enlace_opcion="index.php?g=1&amp;f=$f_destino";
			break;
}

?>
