<?php
//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>vFORMULARIO HEAD<br>";
//echo "formulario head<br>";
//echo "action: ",$action,"<br>";

if($action=="ins"){
	$maximopermitido=$variablesubmodulo_maxobjetos;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_comprobamoscupo.php'; include("$ruta");
}




if($action=="ins"){
	//echo "<br><br><br><br><br><br><br>******** PROCESO DE INSERT ***********<br>";
	if($hago_insert=="SI"){
		if($permiso_insert=="SI"){ 
	//echo "<br><br><br><br><br><br><br>******** permiso_insert ***********<br>";

			$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_insert.php'; include("$ruta");  $action_original="ins";
		}
	}
}



if($action=="upd"){
	//echo "<br>******** PROCESO DE UPDATE ***********<br>";
	if($action_original=="ins"){ $permiso_update="SI"; }

		if($permiso_update=="SI"){ 

			$ruta = $variableadmin_prefijo_bd.'0_comunes/capturo_campos_formulario.php'; include("$ruta");

			if(variablesubmodulo_control_datos_repetidos_activar!="NO"){
				$ruta = $variableadmin_prefijo_bd.'0_comunes/controlCamposRepetidos.php'; include("$ruta");  
			}

			$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_update.php'; include("$ruta");

		}
}


$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_select.php'; include("$ruta");  // Sea cual sea el proceso, lo &uacute;ltimo que se hace es el SELECT correspondiente

if(variablesubmodulo_control_datos_repetidos_activar!="NO"){
$ruta = $variableadmin_prefijo_bd.'0_comunes/controlCamposEnBlanco.php'; include("$ruta");  // Hacemos el Control de los Campos que se han quedado en blanco
}




// Definimos las Condiciones para que el Formulario est&eacute; activo, es decir, se puedan insertar y actualizar datos.
if($action=="list"){ $action="upd"; }
if($action=="ins"){ if($permiso_insert=="SI"){$formulario_activo="SI";} }
if($action=="upd"){ if($permiso_update=="SI"){$formulario_activo="SI";} }



//if($es_de_superadministrador=="SI" and $iu!="1"){$muestro_formulario="NO";} // Si el dato es de superadministrador, pero  el usuario que tiene iniciada la sesi&oacute;n NO es el SuperAdministrador. Entonces NO se mostrar&aacute; el Formulario. Esto se hace para evitar que un usuario cualquiera pase por la URL un numero de objeto que corresponda a un dato de un superadministrador.

?>