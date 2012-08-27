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

// CELDA CABECERA COLUMNA DOS ____________________________________________________________________________
echo '<td'.$variablesubmodulo_listado_estilo_columna_2.' class="celdaCabeceraListado">';
if($variablesubmodulo_listado_orden_asc_desc_columna_2=="SI"){
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_2;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_desc.php'; include("$ruta");
}
echo $variablesubmodulo_listado_etiqueta_columna_2;
if($variablesubmodulo_listado_orden_asc_desc_columna_2=="SI"){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_asc.php'; include("$ruta");
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_2;
}
echo '</td>';

// CELDA CABECERA COLUMNA TRES ____________________________________________________________________________
echo '<td'.$variablesubmodulo_listado_estilo_columna_3.' class="celdaCabeceraListado">';
if($variablesubmodulo_listado_orden_asc_desc_columna_3=="SI"){
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_3;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_desc.php'; include("$ruta");
}
echo $variablesubmodulo_listado_etiqueta_columna_3;
if($variablesubmodulo_listado_orden_asc_desc_columna_3=="SI"){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_asc.php'; include("$ruta");
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_3;
}
echo '</td>';

// CELDA CABECERA COLUMNA CUATRO ____________________________________________________________________________
echo '<td'.$variablesubmodulo_listado_estilo_columna_4.' class="celdaCabeceraListado">';
if($variablesubmodulo_listado_orden_asc_desc_columna_4=="SI"){
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_4;
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_desc.php'; include("$ruta");
}
echo $variablesubmodulo_listado_etiqueta_columna_4;
if($variablesubmodulo_listado_orden_asc_desc_columna_4=="SI"){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/listado_orden_asc.php'; include("$ruta");
	$campoCriterioOrden=$variablesubmodulo_listado_criterio_orden_columna_4;
}
echo '</td><td>&nbsp;</td>';
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

// CELDA LISTADO COLUMNA DOS ____________________________________________________________________________
echo '<td class="celdasFilasListado">'.$$variablesubmodulo_listado_campo_columna_2.'</td>';

// CELDA LISTADO COLUMNA TRES ____________________________________________________________________________
echo '<td class="celdasFilasListado">'.$$variablesubmodulo_listado_campo_columna_3.'</td>';

// CELDA LISTADO COLUMNA CUATRO ____________________________________________________________________________
echo '<td class="celdasFilasListado">'.$$variablesubmodulo_listado_campo_columna_4.'</td><td>&nbsp;</td>';
echo '</tr>';


} // INICIO: while#1 ________________________


?>