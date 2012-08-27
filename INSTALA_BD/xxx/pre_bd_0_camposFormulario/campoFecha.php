<?php

	$nombreCampoDia="dia_".$campoauditar; 
	$nombreCampoMes="mes_".$campoauditar;  
	$nombreCampoYear="year_".$campoauditar;  


echo '<div class="'.$estiloEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campo.php'; include("$ruta");
echo '</div>';

echo '<div class="'.$estiloCampo.'">'; 
				echo '<select name="'.$nombreCampoDia.'">';
				echo '<option selected>'.$$nombreCampoDia.'</option>';
				listado_dias();
				echo "</select>";

				echo '&nbsp;<select name="'.$nombreCampoMes.'">';
				echo '<option value="'.$$nombreCampoMes.'" selected>'; echo veo_nombremes($$nombreCampoMes); echo '</option>';
				listado_meses();
				echo "</select>";
				
				echo '&nbsp;<select name="'.$nombreCampoYear.'">';
				echo '<option selected>'.$$nombreCampoYear.'</option>';
				listado_years($intervaloYears);
				echo "</select>";
echo '</div>';
		
?>