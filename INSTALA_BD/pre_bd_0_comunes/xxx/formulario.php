<?php
	$ruta = $variableadmin_prefijo_bd.'0_camposFormulario/loadFuncionesCamposFormulario.php'; include("$ruta");

if($formulario_activo=="SI"){
echo '<form name="form" method="post" action="index.php">
<input type="hidden" name="f" value="'.$f.'">
<input type="hidden" name="f1" value="'.$f1.'">
<input type="hidden" name="s1" value="'.$s1.'">
<input type="hidden" name="action" value="upd">
<input type="hidden" name="action_original" value="'.$action_original.'">
<input type="hidden" name="vengode" value="'.$vengode.'">
<input type="hidden" name="num_objeto_md5" value="'.$num_objeto_md5.'">
<input type="hidden" name="f_Padre" value="'.$f_Padre.'">
<input type="hidden" name="f1_Padre" value="'.$f1_Padre.'">
<input type="hidden" name="md5_Padre" value="'.$md5_Padre.'">
<input type="hidden" name="copio_Padre" value="'.$copio_Padre.'">';

if($errorFormulario>0){
	$ruta = $variableadmin_prefijo_bd.'0_comunes/formularioMensajesError.php'; include("$ruta");
}


if(strlen(trim($variablesubmodulo_input_hidden_particulares))>1){
$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_input_hidden_particulares; if(file_exists($ruta)){ include("$ruta"); }
}


}else{ echo '<form name="form">'; }


$ruta = $f.'/'.$f1.'/1_formulario_campos.php'; if(file_exists($ruta)){ include("$ruta"); }

echo '</form>';

?>