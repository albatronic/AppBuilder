<?php
echo '<form name="form" method="post" action="index.php">
<input type="hidden" name="f" value="'.$f.'">
<input type="hidden" name="f1" value="'.$f1.'">
<input type="hidden" name="s1" value="'.$s1.'">';

$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_listado_campo_condicion_1_campoespecial.'.php';  
if(file_exists($ruta)){
	include("$ruta");
}else{

	if(strlen(trim($variablesubmodulo_listado_campo_condicion_1))>0){
	echo $variablesubmodulo_listado_etiqueta_campo_condicion_1.'<input type="text" name="criterio1" value="'.$criterio1.'" class="campotexto_205">&nbsp;';
	}

}



$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_listado_campo_condicion_2_campoespecial.'.php';  
if(file_exists($ruta)){
	include("$ruta");
}else{

if(strlen(trim($variablesubmodulo_listado_campo_condicion_2))>0){
echo $variablesubmodulo_listado_etiqueta_campo_condicion_2.'<input type="text" name="criterio2" value="'.$criterio2.'" class="campotexto_205">&nbsp;';
}

}




$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_listado_campo_condicion_3_campoespecial.'.php';  
if(file_exists($ruta)){
	include("$ruta");
}else{

if(strlen(trim($variablesubmodulo_listado_campo_condicion_3))>0){
echo $variablesubmodulo_listado_etiqueta_campo_condicion_3.'<input type="text" name="criterio3" value="'.$criterio3.'" class="campotexto_205">&nbsp;';
}

}



//echo '&nbsp;&nbsp;D.N.I.: <input type="text" name="criterio2" value="'.$criterio2.'" class="cajastexto" size="20">';

echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/espacio5.gif" alt="" title="" />';

echo '<input type="image" src="'.$variableadmin_prefijo_bd.'imagenes/btn_buscar.jpg" align="absmiddle">';

echo '</form>';



?>