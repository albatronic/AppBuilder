<?php
echo '<script type="text/javascript" src="'.$variableadmin_prefijo_bd.'js/jquery-1.7.2.min.js"></script>';
echo '<script type="text/javascript" src="'.$variableadmin_prefijo_bd.'js/pop-up.js"></script>';

echo '<script language="JavaScript" type="text/JavaScript">
<!--
function submitformulario() { 
  window.form.submit();
}

function solo_cerrarventana() { 
  window.close();
}';

if($copio_Padre=="SI"){
if(strlen(trim($md5_Padre))>0){
if($run_copy==SI){
		echo 'function submit_hijo_y_submit_padre() { 
		  document.form.submit();
		opener.document.all.'.$campo_copy_Padre.'.value = document.form_oculto.id_problema_popup.value;
		opener.document.form.submit();
		  window.close();
		}';
}
}
}

echo '//-->
</script>';


	$ruta = $f.'/'.$f1.'/1_javascript_particulares_este_modulo.php';  if (file_exists($ruta)){include("$ruta");}

?>