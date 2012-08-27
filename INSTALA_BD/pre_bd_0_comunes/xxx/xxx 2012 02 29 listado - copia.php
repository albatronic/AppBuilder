<?php

if($permiso_list=="SI"){ // INICIO: $permiso_list=="SI"

echo '<div class="filaBuscadorListado">';
if($variablesubmodulo_listado_buscador=="SI"){}
echo '</div>';


echo '<div class="filaAbecedarioListado">';
echo '<div class="abecedario">';
if($variablesubmodulo_listado_abecedario=="SI"){echo 'a b c d e f';}
echo '</div>';
echo '<div class="anteriorSiguienteListados">';
echo '<img src="pre_bd_imagenes/btn_anterior.jpg">';
echo '<img src="pre_bd_imagenes/btn_siguiente.jpg">';
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


echo '<div class="filaTablaListado">';
echo '<table border="0" cellspacing="0" cellpadding="0">';
echo '<tr style="background-color:#ddd;"><td style="width:75px; text-align:left; font-weight:bold; height:30px;"></td><td style="padding-left:20px; text-align:left; font-weight:bold;">Nombre</td><td style="background-color:#00ff00; width:100px;">DNI/CIF</td><td>Dirección</td></tr>';

echo '<tr style="border-bottom:1px #ddd solid;"><td style="padding-bottom:20px;">xx</td><td>Juan Cuenca</td><td>24278227W</td><td>Calle Miguel Servet 26</td></tr>';

echo '<tr style="border-bottom:1px #ddd solid;"><td style="padding-bottom:20px;">xx</td><td>Juan Cuenca</td><td>24278227W</td><td>Calle Miguel Servet 26</td></tr>';

echo '</table>';
echo '</div>';


} // FIN: $permiso_list=="SI"

?>