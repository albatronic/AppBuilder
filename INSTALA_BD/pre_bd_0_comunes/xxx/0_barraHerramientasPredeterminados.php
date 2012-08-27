<?php
echo '<a href="'.$enlace_opcion.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_salir.jpg" alt="Salir de la Aplicaci&oacute;n" title="Salir de la Aplicaci&oacute;n" /></a>';

echo '<a href="'.$enlace_opcion.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_cerrarsesion.jpg" alt="Cerrar la Sesi&oacute;n" title="Cerrar la Sesi&oacute;n" /></a>';

$valor_f_inicio=$variableadmin_prefijo_bd.'gs_h';
if($f!=$valor_f_inicio){
$destino_inicio='f='.$variableadmin_prefijo_bd.'gs_h';
echo '<a href="index.php?g=1&amp;'.$destino_inicio.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_inicio.jpg" alt="Inicio" title="Inicio" /></a>';
}

if($s1=="0_formulario"){
echo '<a href="#" OnClick="submitformulario()"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_guardar.jpg"  alt="Guardar los Cambios" title="Guardar los Cambios"></a>';
}


if($f1!="1_menu_principal"){
$destino_inicio='f='.$variableadmin_prefijo_bd.'gs_h';
echo '<a href="index.php?g=1&amp;f='.$f.'&amp;f1='.$f1.'&amp;s1=0_nuevo&amp;f_Padre='.$f_Padre.'&amp;f1_Padre='.$f1_Padre.'&amp;md5_Padre='.$md5_Padre.'&amp;copio_Padre='.$copio_Padre.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_nuevo.jpg" alt="Nuevo" title="Nuevo" /></a>';
}


if($f1!="1_menu_principal"){
$destino_inicio='f='.$variableadmin_prefijo_bd.'gs_h';
echo '<a href="index.php?g=1&amp;f='.$f.'&amp;f1='.$f1.'&amp;s1=0_listado&f_Padre='.$f_Padre.'&f1_Padre='.$f1_Padre.'&md5_Padre='.$md5_Padre.'&copio_Padre='.$copio_Padre.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_listado.jpg" alt="Listado" title="Listado" /></a>';
}


if($copio_Padre=="SI"){
if(strlen(trim($md5_Padre))>0){
if($s1=="0_formulario"){
echo '<a href="index.php?g=1&f='.$f.'&f1='.$f1.'&s1='.$s1.'&pag='.$pag.'&orden='.$orden.'&criterio='.$criterio.'&action='.$action.'&num_objeto_md5='.$num_objeto_md5.'&vengode='.$vengode.'&f_Padre='.$f_Padre.'&f1_Padre='.$f1_Padre.'&md5_Padre='.$md5_Padre.'&copio_Padre='.$copio_Padre.'&run_copy=SI">';
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="Copiar este valor en el Formulario Padre" title="Copiar este valor en el Formulario Padre" /></a>';
}
}
}


if($f!=$valor_f_inicio){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/0_barraHerramientasBotonSubir.php'; include("$ruta");
}

/*if($f!="gs_h"){
echo $f1;
	if(strlen(trim($f1))<1){$destino_f="gs_h";}else{$destino_f=$f;}
	if($f1=="1_menu_principal"){$destino_f="gs_h";}
	if($f1!="1_menu_principal"){$destino_f=$f.'&f1='.$f1;}

echo '<a href="index.php?g=1&f='.$destino_f.'"><img src="imagenes_barraherramientas/btn_herr_subir.jpg" alt="Subir un Nivel" title="Subir un Nivel" /></a>';
}*/

?>