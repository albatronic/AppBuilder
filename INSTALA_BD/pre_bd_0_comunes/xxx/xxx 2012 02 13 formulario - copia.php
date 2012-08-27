<?php



/*
if($action=="ins"){
	$maximopermitido=$var_ent_maxobjetos;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_comprobamoscupo.php'; include("$ruta");
}




		if($action=="ins"){
			//echo "<br>******** PROCESO DE INSERT ***********<br>";
					if($hago_insert=="SI"){
						if($permiso_insert=="SI"){ include('bd_insert.php'); $action_original="ins";}
					}
		}


		if($action=="upd"){
			//echo "<br>******** PROCESO DE UPDATE ***********<br>";
			if($action_original=="ins"){ $permiso_update="SI"; }
			if($permiso_update=="SI"){ include('bd_update.php'); }
		}


		include('bd_select.php'); // Sea cual sea el proceso, lo &uacute;ltimo que se hace es el SELECT correspondiente




// Definimos las Condiciones para que el Formulario est&eacute; activo, es decir, se puedan insertar y actualizar datos.
if($action=="list"){ $action="upd"; }
if($action=="ins"){ if($permiso_insert=="SI"){$formulario_activo="SI";} }
if($action=="upd"){ if($permiso_update=="SI"){$formulario_activo="SI";} }



if($es_de_superadministrador=="SI" and $iu!="1"){$muestro_formulario="NO";} // Si el dato es de superadministrador, pero  el usuario que tiene iniciada la sesi&oacute;n NO es el SuperAdministrador. Entonces NO se mostrar&aacute; el Formulario. Esto se hace para evitar que un usuario cualquiera pase por la URL un numero de objeto que corresponda a un dato de un superadministrador.

//echo "muestro_formulario: ",$muestro_formulario,"<br>";
//echo "num_objeto: ",$num_objeto,"<br>";
*/

// INICIO: Mostramos Formulario
if($muestro_formulario!="NO"){ 
if($num_objeto > 0){ // S&oacute;lo mostramos el Formulario si tenemos el Nº de Registro correspondiente.
echo '<table width="381" border="0" cellspacing="0" cellpadding="0">';


	$titulo_formulario=$conf_titulo_modulo; // TITULO DEL FORMULARIO
	include("recursos_api/titulo_formulario_colspan_2.php"); 
	include("recursos_api/linea_espacio_colspan_2.php"); // LINEA DE ESPACIO

/*
	$ficheroayuda="catalogo_familias_formulario";
	include("recursos_api/boton_ayuda_formulario_colspan_2.php"); // BOT&Oacute;N DE AYUDA 
*/

if($formulario_activo=="SI"){
//echo "2 pertenece_a: ",$pertenece_a,"<br>";

echo '<form name="form" method="post" action="index.php">
<input type="hidden" name="i" value="1">
<input type="hidden" name="dch" value="1">
<input type="hidden" name="op" value="'.$op.'">
<input type="hidden" name="menu" value="'.$menu.'">
<input type="hidden" name="f" value="'.$f.'">
<input type="hidden" name="central" value="'.$central.'">
<input type="hidden" name="es_privado" value="'.$es_privado.'">
<input type="hidden" name="action" value="upd">
<input type="hidden" name="action_original" value="'.$action_original.'">
<input type="hidden" name="modulo" value="'.$modulo.'">
<input type="hidden" name="num_objeto_md5" value="'.$num_objeto_md5.'">';

if($conf_campos_hidden_particulares=="SI"){
	$ruta_campos_hidden_particulares = $modulo.'/036_campos_hidden_particulares.php'; 
	if (file_exists($ruta_campos_hidden_particulares)){include("$ruta_campos_hidden_particulares");}
}


}else{ echo '<form name="form">'; }

// Con esta Fila en blanco, definimos la anchura de las Celdas de la Tabla **********
	echo '<tr>
    <td width="151"><img src="imagenes/espacio.gif" width="1" height="1" border="0"></td>
	<td width="230"><img src="imagenes/espacio.gif" width="1" height="1" border="0"></td>
    </tr>'; // **************************************************************************

$ruta_cabecera_formulario = $modulo.'/033_cabecera_formulario.php'; if (file_exists($ruta_cabecera_formulario)){ include("$ruta_cabecera_formulario"); }


// ****************************************************************************************************
if($iu=="1"){$estilocampo="txtrojo"; $estilodato="txtrojogrueso"; $var_ent_mostrar_numobjeto="SI";}else{$estilocampo="txtazuloscuro"; $estilodato="txtazulgrueso";}
	if($var_ent_mostrar_numobjeto=="SI"){
			echo '<tr>'; 
			echo '<td align="left" valign="middle" class="'.$estilocampo.'">'.$conf_etiqueta_campo_num.': </td>';
			echo '<td align="left" valign="middle" class="'.$estilodato.'">';
			echo $select_campo_num;
			echo '</td>';
			echo '</tr>';
	}


// ****************************************************************************************************
	if($iu=="1"){
			echo '<tr>'; 
			echo '<td align="left" valign="middle" class="txtrojo">MD5: </td>';
			echo '<td align="left" valign="middle" class="txtrojogrueso">';
			echo $select_campo_md5;
			echo '</td>';
			echo '</tr>';
	}


// ****************************************************************************************************
if($iu=="1"){$variable_mostrar_urlamigable="SI";}
if($variable_mostrar_urlamigable=="SI"){
	echo '<tr>'; 
	echo '<td align="left" valign="top" class="txtazuloscuro">URL: </td>';
			echo '<td align="left" valign="middle" class="txtazulgrueso">';
			echo $url_amigable;
			echo '</td>';
	echo '</tr>';
}


// ****************************************************************************************************
if($iu=="1"){$variable_campo_urlamigable_manual="SI";}
if($variable_campo_urlamigable_manual=="SI"){
	echo '<tr>'; 
	echo '<td align="left" valign="top" class="txtazuloscuro" colspan="2">URL Amigable Manual: </td></tr>';
	echo '<tr><td align="left" valign="top" class="txtazulgrueso" colspan="2">';
	echo '<input type="text" name="url_amigable_manual" value="'.$url_amigable_manual.'" class="cajastexto2" size="71" OnBlur="submitformulario()">';
	echo '</td>';
	echo '</tr>';
}else{
		echo '<input type="hidden" name="url_amigable_manual" value="'.$url_amigable_manual.'">';
}




	$ruta_formulario_campos = $modulo.'/009_formulario_campos.php'; include("$ruta_formulario_campos");


// ****************************************************************************************************
if($conf_metainformacion_formulario=="SI"){
		include('formulario_campos_metatags.php');
}

// ****************************************************************************************************
if($formulario_activo=="SI"){
	include("recursos_api/linea_separacion_colspan_2.php"); // LINEA DE SEPARACI&Oacute;N ***************************************


if($conf_botones_formulario_particulares=="SI"){

$botones_formulario_particulares = $modulo.'/032_botones_formulario_particulares.php'; include("$botones_formulario_particulares"); 

}else{
	include("recursos_api/boton_guardar_y_espacio_colspan_2.php"); // BOT&Oacute;N GUARDAR DEL FORMULARIO ***********************
}

}

echo '</form>';

// Situamos el Foco en el Campo indicado mediante la variable $campo_foco
if($conf_activar_campo_foco!="NO"){
if(strlen($conf_nombre_campo_foco) > 0){
		$campo_foco=$conf_nombre_campo_foco;
		include ("recursos_api/foco_form.php");
}
}

echo '</table>';
} 

} // FIN: Mostramos Formulario

?>