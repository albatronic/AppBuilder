<?php
if($variablesubmodulo_listado_campo_condicion_1_valorexacto=="SI"){$condicionCriterio1="$variablesubmodulo_listado_campo_condicion_1='$criterio1'";}else{$condicionCriterio1="$variablesubmodulo_listado_campo_condicion_1 like '$cadenadebusqueda_1'";}

if($variablesubmodulo_listado_campo_condicion_2_valorexacto=="SI"){$condicionCriterio2="$variablesubmodulo_listado_campo_condicion_2='$criterio2'";}else{$condicionCriterio2="$variablesubmodulo_listado_campo_condicion_2 like '$cadenadebusqueda_2'";}

if($variablesubmodulo_listado_campo_condicion_3_valorexacto=="SI"){$condicionCriterio3="$variablesubmodulo_listado_campo_condicion_3='$criterio3'";}else{$condicionCriterio3="$variablesubmodulo_listado_campo_condicion_3 like '$cadenadebusqueda_3'";}


if($estamosEn=="head"){$camposASeleccionar=$variablesubmodulo_nombre_campo_id;}else{$camposASeleccionar="*";}

if (strlen(trim($abc)) > 0){
	$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $variablesubmodulo_listado_abecedario_campo_busqueda like '$cadenadebusqueda'";
}else{
	$sql="select $camposASeleccionar from $name_tabla where eliminado='NO'";
}


if ($existe_condicion_1=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio1";}

if ($existe_condicion_2=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio2";}

if ($existe_condicion_3=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio3";}

if ($existe_condicion_1_2=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio1 and $condicionCriterio2";}

if ($existe_condicion_1_2_3=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio1 and $condicionCriterio2 and $condicionCriterio3";}

if ($existe_condicion_1_abc=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio1 and $variablesubmodulo_listado_abecedario_campo_busqueda like '$cadenadebusqueda'";}

if ($existe_condicion_2_abc=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio2 and $variablesubmodulo_listado_abecedario_campo_busqueda like '$cadenadebusqueda'";}

if ($existe_condicion_3_abc=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio3 and $variablesubmodulo_listado_abecedario_campo_busqueda like '$cadenadebusqueda'";}

if ($existe_condicion_1_2_abc=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio1 and $condicionCriterio2 and $variablesubmodulo_listado_abecedario_campo_busqueda like '$cadenadebusqueda'";}

if ($existe_condicion_1_2_3_abc=="SI"){$sql="select $camposASeleccionar from $name_tabla where eliminado='NO' and $condicionCriterio1 and $condicionCriterio2 and $condicionCriterio3 and $variablesubmodulo_listado_abecedario_campo_busqueda like '$cadenadebusqueda'";}


if($estamosEn=="body"){$sql.=" order by $criterio $orden limit $regla, $tampag";}

//echo $sql;

		$res=mysql_query($sql,$db);
		$num_campos=mysql_num_fields($res);

?>