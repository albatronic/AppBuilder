<?php

		
function input_text_generico($classEtiqueta,$classCampo,$etiqueta,$campoauditar)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;

echo '<span class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campo.php'; include("$ruta");
echo '</span>';
echo '<span class="spam_'.$classCampo.'"><input type="text" name="'.$campoauditar.'" value="'.$$campoauditar.'" class="'.$classCampo.'" /></span> ';
}
	
		
?>