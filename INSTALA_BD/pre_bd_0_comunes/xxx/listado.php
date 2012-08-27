<?php

if($permiso_list=="SI"){ // INICIO: $permiso_list=="SI"
	$ruta = $variableadmin_prefijo_bd.'0_camposFormulario/loadFuncionesCamposFormulario.php'; include("$ruta");

echo '<div class="filaBuscadorListado">';
if($variablesubmodulo_listado_buscador=="SI"){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_formulario_busqueda.php'; include("$ruta");
}
echo '</div>';


echo '<div class="filaAbecedarioListado">';
echo '<div class="abecedario">';
if($variablesubmodulo_listado_abecedario=="SI"){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_abecedario_cabecera.php'; include("$ruta");
}
echo '</div>';
echo '<div class="anteriorSiguienteListados">';
$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_anterior_siguiente.php'; include("$ruta");
echo '</div>';
echo '</div>';


echo '<div class="filaTotalesListado">';
echo "Total Registros: ";
echo '<b>'.$total.'</b>';
echo '&nbsp;&nbsp;'; 
echo "Página: ";
echo '<b>'.$pag.'</b> / <b>'.$total_pags.'</b>';
echo '&nbsp;&nbsp;';
echo '</div>';


echo '<div class="filaTablaListado">'; // INICIO: <div class="filaTablaListado">
echo '<table>';

$estamosEn="body"; $ruta = $variableadmin_prefijo_bd.'0_comunes/listado_sql.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_comunes/'.$variablesubmodulo_listado_plantilla; include("$ruta");




echo '</table>';
echo '</div>'; // FIN: <div class="filaTablaListado">


} // FIN: $permiso_list=="SI"

?>