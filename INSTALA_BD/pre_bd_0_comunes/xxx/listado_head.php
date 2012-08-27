<?php
//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
if($permiso_list=="SI"){ // INICIO: $permiso_list=="SI"

if(strlen(trim($md5_Padre))>0){ // CARGAMOS LOS VALORES QUE NOS ENVÍA EL FORMULARIO PADRE
$ruta = $f_Padre.'/'.$f1_Padre.'/1_valores_pasados_por_fomulario_padre.php'; include("$ruta"); //if (file_exists($ruta)){}
}

if (strlen(trim($criterio1)) < 1){
if (strlen(trim($variablesubmodulo_listado_campo_condicion_1_valordefecto)) > 0){$criterio1=$variablesubmodulo_listado_campo_condicion_1_valordefecto;
}
	if(strlen(trim($md5_Padre))>0){
	//$criterio1=$variablesubmodulo_listado_campo_condicion_1_valordefecto_Padre;
	}
}


if (strlen(trim($criterio2)) < 1){
if (strlen(trim($variablesubmodulo_listado_campo_condicion_2_valordefecto)) > 0){$criterio2=$variablesubmodulo_listado_campo_condicion_2_valordefecto;
}
}

if (strlen(trim($criterio3)) < 1){
if (strlen(trim($variablesubmodulo_listado_campo_condicion_3_valordefecto)) > 0){$criterio3=$variablesubmodulo_listado_campo_condicion_3_valordefecto;
}
}


if (!isset($pag)){ 
	$pag=1;
	$orden=$variablesubmodulo_listado_orden;
	$criterio=$variablesubmodulo_listado_campo_ordenacion;
}
	$tamano=$variablesubmodulo_listado_tamanio_paginacion;



if (strlen(trim($criterio1)) > 0){$existe_condicion_1="SI"; $cadenadebusqueda_1="%".$criterio1."%";}
if (strlen(trim($criterio2)) > 0){$existe_condicion_2="SI"; $cadenadebusqueda_2="%".$criterio2."%";}
if (strlen(trim($criterio1)) > 0 and strlen(trim($criterio2)) > 0){$existe_condicion_1_2="SI";}

if (strlen(trim($criterio3)) > 0){$existe_condicion_3="SI"; $cadenadebusqueda_3="%".$criterio3."%";}
if (strlen(trim($criterio1)) > 0 and strlen(trim($criterio2)) > 0 and strlen(trim($criterio3)) > 0){$existe_condicion_1_2_3="SI";}

if (strlen(trim($abc)) > 0){$existe_condicion_abc="SI"; $cadenadebusqueda=$abc."%";}

//$cadenadebusqueda=$abc."%";
if($existe_condicion_1=="SI" and $existe_condicion_abc=="SI"){$existe_condicion_1_abc="SI";}
if($existe_condicion_2=="SI" and $existe_condicion_abc=="SI"){$existe_condicion_2_abc="SI";}
if($existe_condicion_1_2=="SI" and $existe_condicion_abc=="SI"){$existe_condicion_1_2_abc="SI";}
if($existe_condicion_3=="SI" and $existe_condicion_abc=="SI"){$existe_condicion_3_abc="SI";}
if($existe_condicion_1_2_3=="SI" and $existe_condicion_abc=="SI"){$existe_condicion_1_2_3_abc="SI";}


$name_tabla=$variablesubmodulo_tabla_submodulo;

$estamosEn="head"; $ruta = $variableadmin_prefijo_bd.'0_comunes/listado_sql.php'; include("$ruta");


		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		$tampag=$tamano;
		$resto=$total%$tampag;
		if($resto==0){
			$agrego=0;
		}else{
			$agrego=1;
		}
		$total_pags=($total-$resto)/$tampag+$agrego;
		$regla=($pag-1)*$tampag;
		if($total==0){
			$pag=0;
		}


} // FIN: $permiso_list=="SI"

?>