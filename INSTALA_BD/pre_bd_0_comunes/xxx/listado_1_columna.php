<?php

// FILA CERO: CABECERA
echo '<tr class="cabeceraListado">';

// CELDA CABECERA COLUMNA CERO ____________________________________________________________________________
echo '<td'.$variablesubmodulo_listado_estilo_columna_0.'>';
echo '</td>';

// CELDA CABECERA COLUMNA UNO ____________________________________________________________________________
echo '<td'.$variablesubmodulo_listado_estilo_columna_1.' class="celdaCabeceraListado">';
if($variablesubmodulo_listado_orden_asc_desc_columna_1=="SI"){
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_1;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_desc.php'; include("$ruta");
}
	echo $variablesubmodulo_listado_etiqueta_columna_1;
if($variablesubmodulo_listado_orden_asc_desc_columna_1=="SI"){
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_1;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_asc.php'; include("$ruta");
}
echo '</td>';
echo '</tr>';


while ($reg=mysql_fetch_array($res,MYSQL_NUM)){ // INICIO: while#1 ________________________
for ($i=0; $i<$num_campos; $i++){ // INICIO: bucle for ___________________________________________
	$nombre_campo=mysql_field_name($res,$i);
	$$nombre_campo=$reg[$i];
} // FIN: bucle for ___________________________________________
$num_objeto_md5=$$variablesubmodulo_nombre_campo_md5;
echo '<tr class="filasListado">';

// CELDA LISTADO COLUMNA CERO ____________________________________________________________________________
echo '<td class="celdaIconosListado">';
$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_iconos_filas.php'; include("$ruta");
echo '</td>';

// CELDA LISTADO COLUMNA UNO ____________________________________________________________________________
echo '<td class="celdasFilasListado">'.$$variablesubmodulo_listado_campo_columna_1.'</td>';
echo '</tr>';


} // INICIO: while#1 ________________________


?>