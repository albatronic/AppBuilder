<?php

// INPUT TEXT GENÉRICO ________________________________________________________________________		
function input_text_generico($classEtiqueta,$classCampo,$etiqueta,$campoauditar)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campo.php'; include("$ruta");
echo '</div>';
echo '<div class="spam_'.$classCampo.'"><input type="text" name="'.$campoauditar.'" value="'.$$campoauditar.'" class="'.$classCampo.'" /></div> ';
}

// TEXTAREA FILA COMPLETA ________________________________________________________________________		
function textarea_fila_completa($etiqueta,$campoauditar,$estiloFilaEtiqueta,$estiloFilaCampo,$classTextArea)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;

echo '<div class="'.$estiloFilaEtiqueta.'">'; 
$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campo.php'; include("$ruta");
echo '</div>'; 

echo '<div class="'.$estiloFilaCampo.'">'; 
echo '<textarea name="'.$campoauditar.'"  class="'.$classTextArea.'">'.$$campoauditar.'</textarea>';
echo '</div>'; 
}


// INPUT RADIO DOS OPCIONES ________________________________________________________________________		
function input_radio_dos_opciones($classContenedor,$valorSi,$valorNo,$EtiquetaSi,$EtiquetaNo,$campoauditar)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;

echo '<div class="'.$classContenedor.'">'; 
	if($$campoauditar==$valorSi){
	echo '<input name="tipo" type="radio" value="'.$valorSi.'" checked> '.$EtiquetaSi;
	echo '&nbsp;&nbsp;';
	echo '<input name="tipo" type="radio" value="'.$valorNo.'"> '.$EtiquetaNo;
	}else{
	echo '<input name="tipo" type="radio" value="'.$valorSi.'"> '.$EtiquetaSi;
	echo '&nbsp;&nbsp;';
	echo '<input name="tipo" type="radio" value="'.$valorNo.'" checked> '.$EtiquetaNo;
	}
echo '</div>';
}

// INPUT RADIO DOS OPCIONES SUBMIT AL CAMBIAR VALOR ___________________________________________________________		
function input_radio_dos_opciones_submit($classContenedor,$valorSi,$valorNo,$EtiquetaSi,$EtiquetaNo,$campoauditar)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;

echo '<div class="'.$classContenedor.'">'; 
	if($$campoauditar==$valorSi){
	echo '<input name="tipo" type="radio" value="'.$valorSi.'" checked OnClick="submitformulario()"> '.$EtiquetaSi;
	echo '&nbsp;&nbsp;';
	echo '<input name="tipo" type="radio" value="'.$valorNo.'" OnClick="submitformulario()"> '.$EtiquetaNo;
	}else{
	echo '<input name="tipo" type="radio" value="'.$valorSi.'" OnClick="submitformulario()"> '.$EtiquetaSi;
	echo '&nbsp;&nbsp;';
	echo '<input name="tipo" type="radio" value="'.$valorNo.'" checked OnClick="submitformulario()"> '.$EtiquetaNo;
	}
echo '</div>';
}


// CHECKBOX ETIQUETA A LA DERECHA ________________________________________________________________________		
function checkbox_etiqueta_derecha($campoauditar,$etiqueta)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;

if($$campoauditar == "1"){
		echo '<input type="checkbox" name="'.$campoauditar.'" value="1" checked />&nbsp;';
}else{
		echo '<input type="checkbox" name="'.$campoauditar.'" value="1" />&nbsp;';
}
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campo.php'; include("$ruta");


}





/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
*/

// SELECT GENÉRICO ________________________________________________________________________		
function select_generico($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."'"; 
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}

}


echo "</select>";

echo '</div>'; // FIN: contenedor campo ***********
}


// SELECT GENÉRICO SUBMIT AL CAMBIAR VALOR ________________________________________________________________________		
function select_generico_submit($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."'"; 
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}

}


echo "</select>";

echo '</div>'; // FIN: contenedor campo ***********
}



/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
$campo_dependiente: Campo que depende de un valor Externo 
$valor_dependiente: Valor Externo del que depende este Select
*/

// SELECT DEPENDIENTE DE OTRO VALOR SUBMIT AL CAMBIAR VALOR ________________________________________________________________________		
// En esta función si no hay ningún valor seleccionado, busca el primero alfabéticamente que corresponda al valor dependiente
function select_dependiente_submit($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect,$campo_dependiente,$valor_dependiente)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $$valor_dependiente;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."' and $campo_dependiente='".$$valor_dependiente."'"; 
$res=mysql_query($sql,$db);
$totalcoincidencias=mysql_num_rows($res);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($totalcoincidencias==0){
$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where  $campo_dependiente='".$$valor_dependiente."' order by $texto_mostrar_tabla_relacionada asc limit 0,1"; 
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}
} 

if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_dependiente='".$$valor_dependiente."' and publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}

}


echo "</select>";

echo '</div>'; // FIN: contenedor campo ***********
}



/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
$campo_dependiente: Campo que depende de un valor Externo 
$valor_dependiente: Valor Externo del que depende este Select
*/


// SELECT DEPENDIENTE DE OTRO VALOR SUBMIT AL CAMBIAR VALOR ________________________________________________________________________		
// En esta función si no hay ningún valor seleccionado, lo deja en blanco
function select_dependiente_submit_campo_vacio($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect,$campo_dependiente,$valor_dependiente)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $$valor_dependiente;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."' and $campo_dependiente='".$$valor_dependiente."'"; 
$res=mysql_query($sql,$db);
$totalcoincidencias=mysql_num_rows($res);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($totalcoincidencias==0){
	$valor_busqueda_seleccionado_desplegable="";
	$txt_mostrar_seleccionado_desplegable="";
} 

//if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
//}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_dependiente='".$$valor_dependiente."' and publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}

}


echo "</select>";

echo '</div>'; // FIN: contenedor campo ***********
}



/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
$campo_dependiente1: PRIMER CAMPO que depende de un valor Externo 
$valor_dependiente1: Valor Externo del que depende este Select del PRIMER CAMPO
$campo_dependiente2: SEGUNDO CAMPO que depende de un valor Externo 
$valor_dependiente2: Valor Externo del que depende este Select del SEGUNDO CAMPO
*/


// SELECT DEPENDIENTE DE DOS VALORES CON SUBMIT AL CAMBIAR VALOR ________________________________________________________________________		
// En esta función si no hay ningún valor seleccionado, lo deja en blanco
function select_dependiente_dosvalores_submit_campo_vacio($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect,$campo_dependiente1,$valor_dependiente1,$campo_dependiente2,$valor_dependiente2)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $$valor_dependiente1;
global $$valor_dependiente2;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."' and $campo_dependiente1='".$$valor_dependiente1."' and $campo_dependiente2='".$$valor_dependiente2."'"; 
$res=mysql_query($sql,$db);
$totalcoincidencias=mysql_num_rows($res);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($totalcoincidencias==0){
	$valor_busqueda_seleccionado_desplegable="";
	$txt_mostrar_seleccionado_desplegable="";
} 

//if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
//}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_dependiente1='".$$valor_dependiente1."' and $campo_dependiente2='".$$valor_dependiente2."' and publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}

}


echo "</select>";

echo '</div>'; // FIN: contenedor campo ***********
}





/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal ---> TOMA EL MISMO VALOR QUE $campo_copy_Padre [Nombre del campo del formulario Padre donde se copiará el dato seleccionado en el Pop-Up]
$f_Popup: Valor de $f para el popup que vamos a abrir
$f1_Popup: Valor de $f1 para el popup que vamos a abrir 
$s1_Popup: Valor de $s1 para el popup que vamos a abrir 
$permiso_popup: permiso que tiene que tener para acceder al PopUp
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
*/

// SELECT POPUP GENÉRICO ________________________________________________________________________		
function select_popup_generico($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$f_Popup,$f1_Popup,$s1_Popup,$permiso_popup,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $f;
global $f1;
global $num_objeto_md5;
global $$permiso_popup;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********
$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."'"; 
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}
echo $txt_mostrar_seleccionado_desplegable;

if($$permiso_popup="SI"){
echo '<a href="index.php?g=1&f='.$f_Popup.'&f1='.$f1_Popup.'&s1='.$s1_Popup.'&f_Padre='.$f.'&f1_Padre='.$f1.'&md5_Padre='.$num_objeto_md5.'&copio_Padre=SI" rel="pop-up"><img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';
}

echo '</div>'; // FIN: contenedor campo ***********

}




/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal ---> TOMA EL MISMO VALOR QUE $campo_copy_Padre [Nombre del campo del formulario Padre donde se copiará el dato seleccionado en el Pop-Up] - $campo_copy_Padre se encuentra en [1_run_copy_XXX.php]
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
$f_Popup: Valor de $f para el popup que vamos a abrir
$f1_Popup: Valor de $f1 para el popup que vamos a abrir 
$s1_Popup: Valor de $s1 para el popup que vamos a abrir 
$permiso_popup: permiso que tiene que tener para acceder al PopUp
$action_popup: valor de $action que se le pasa al PopUp para abrirlo
*/
// SELECT GENÉRICO SUBMIT AL CAMBIAR VALOR CON LLAMADA AL POPUP PARA AÑADIR NUEVOS DATOS ________________________________________		
function select_generico_submit_popup($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect,$f_Popup,$f1_Popup,$s1_Popup,$permiso_popup,$action_popup)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $f;
global $f1;
global $num_objeto_md5;
global $$permiso_popup;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."'"; 
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if(strlen(trim($txt_mostrar_seleccionado_listado))>0){
if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}
}

}


echo "</select>";

if($$permiso_popup="SI"){
echo '<a href="index.php?g=1&f='.$f_Popup.'&f1='.$f1_Popup.'&s1='.$s1_Popup.'&f_Padre='.$f.'&f1_Padre='.$f1.'&md5_Padre='.$num_objeto_md5.'&copio_Padre=SI&action='.$action_popup.'" rel="pop-up"><img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';
}

echo '</div>'; // FIN: contenedor campo ***********
}













/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal ---> TOMA EL MISMO VALOR QUE $campo_copy_Padre [Nombre del campo del formulario Padre donde se copiará el dato seleccionado en el Pop-Up] - $campo_copy_Padre se encuentra en [1_run_copy_XXX.php]
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
$campo_dependiente: Campo que depende de un valor Externo 
$valor_dependiente: Valor Externo del que depende este Select

$f_Popup: Valor de $f para el popup que vamos a abrir
$f1_Popup: Valor de $f1 para el popup que vamos a abrir 
$s1_Popup: Valor de $s1 para el popup que vamos a abrir 
$permiso_popup: permiso que tiene que tener para acceder al PopUp
$action_popup: valor de $action que se le pasa al PopUp para abrirlo

*/



// SELECT DEPENDIENTE DE OTRO VALOR SUBMIT AL CAMBIAR VALOR CON LLAMADA AL POPUP PARA AÑADIR NUEVOS DATOS __________________		
// En esta función si no hay ningún valor seleccionado, lo deja en blanco
function select_dependiente_submit_campo_vacio_popup($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect,$campo_dependiente,$valor_dependiente,$f_Popup,$f1_Popup,$s1_Popup,$permiso_popup,$action_popup)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $$valor_dependiente;
global $f;
global $f1;
global $num_objeto_md5;
global $$permiso_popup;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."' and $campo_dependiente='".$$valor_dependiente."'"; 
$res=mysql_query($sql,$db);
$totalcoincidencias=mysql_num_rows($res);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($totalcoincidencias==0){
	$valor_busqueda_seleccionado_desplegable="";
	$txt_mostrar_seleccionado_desplegable="";
} 

//if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
//}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_dependiente='".$$valor_dependiente."' and publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if(strlen(trim($txt_mostrar_seleccionado_listado))>0){
if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}
}

}


echo "</select>";

if($$permiso_popup="SI"){
echo '<a href="index.php?g=1&f='.$f_Popup.'&f1='.$f1_Popup.'&s1='.$s1_Popup.'&f_Padre='.$f.'&f1_Padre='.$f1.'&md5_Padre='.$num_objeto_md5.'&copio_Padre=SI&action='.$action_popup.'" rel="pop-up"><img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';
}

echo '</div>'; // FIN: contenedor campo ***********
}



/*
$classEtiqueta: estilo de la Etiqueta
$classCampo: estilo del contenedor del Campo
$etiqueta: Texto de la Etiqueta
$campoauditar: Campo de la tabla Principal
$campo_id_tabla_relacionada: Campo ID de la tabla Relacionada (mediante el que se establece la relación)
$texto_mostrar_tabla_relacionada: Campo de la tabla Relacionada que contiene el texto que vemos en el desplagable
$tabla_relacionada: Nombre de la tabla Relacionada
$permite_valor_en_blanco: Si toma el valor SI, entonces podemos elegir un valor en blanco (VACÍO)
$classSelect: estilo del select 
$campo_dependiente1: PRIMER CAMPO que depende de un valor Externo 
$valor_dependiente1: Valor Externo del que depende este Select del PRIMER CAMPO
$campo_dependiente2: SEGUNDO CAMPO que depende de un valor Externo 
$valor_dependiente2: Valor Externo del que depende este Select del SEGUNDO CAMPO

$f_Popup: Valor de $f para el popup que vamos a abrir
$f1_Popup: Valor de $f1 para el popup que vamos a abrir 
$s1_Popup: Valor de $s1 para el popup que vamos a abrir 
$permiso_popup: permiso que tiene que tener para acceder al PopUp
$action_popup: valor de $action que se le pasa al PopUp para abrirlo

*/


// SELECT DEPENDIENTE DE DOS VALORES CON SUBMIT AL CAMBIAR VALOR  CON LLAMADA AL POPUP PARA AÑADIR NUEVOS DATOS ___________	
// En esta función si no hay ningún valor seleccionado, lo deja en blanco
function select_dependiente_dosvalores_submit_campo_vacio_popup($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada,$permite_valor_en_blanco,$classSelect,$campo_dependiente1,$valor_dependiente1,$campo_dependiente2,$valor_dependiente2,$f_Popup,$f1_Popup,$s1_Popup,$permiso_popup,$action_popup)
{
global $variableadmin_prefijo_bd;
global $$campoauditar;
global $permiso_auditoriacampo;
global $variableadmin_prefijo_tablas;
global $db;
global $$valor_dependiente1;
global $$valor_dependiente2;
global $f;
global $f1;
global $num_objeto_md5;
global $$permiso_popup;

$nombre_tabla_relacionada=$variableadmin_prefijo_tablas.$tabla_relacionada;

echo '<div class="'.$classEtiqueta.'">'; 
	$ruta = $variableadmin_prefijo_bd.'0_auditoriaCampo/campoSelect.php'; include("$ruta");
echo '</div>';

echo '<div class="spam_'.$classCampo.'">'; // INICIO: contenedor campo ***********

echo '<select name="'.$campoauditar.'" class="'.$classSelect.'" OnChange="submitformulario()">';

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_id_tabla_relacionada='".$$campoauditar."' and $campo_dependiente1='".$$valor_dependiente1."' and $campo_dependiente2='".$$valor_dependiente2."'"; 
$res=mysql_query($sql,$db);
$totalcoincidencias=mysql_num_rows($res);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_desplegable=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_desplegable=$reg["$texto_mostrar_tabla_relacionada"];
}

if($totalcoincidencias==0){
	$valor_busqueda_seleccionado_desplegable="";
	$txt_mostrar_seleccionado_desplegable="";
} 

//if($$campoauditar>0){
echo "<option value='$valor_busqueda_seleccionado_desplegable' selected>$txt_mostrar_seleccionado_desplegable</option>";
//}

if($permite_valor_en_blanco=="SI"){echo "<option value='0'></option>";}

$sql="select $campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada from $nombre_tabla_relacionada where $campo_dependiente1='".$$valor_dependiente1."' and $campo_dependiente2='".$$valor_dependiente2."' and publicar='SI' and eliminado='NO' order by $texto_mostrar_tabla_relacionada asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$valor_busqueda_seleccionado_listado=$reg["$campo_id_tabla_relacionada"];
	$txt_mostrar_seleccionado_listado=$reg["$texto_mostrar_tabla_relacionada"];

if(strlen(trim($txt_mostrar_seleccionado_listado))>0){
if($valor_busqueda_seleccionado_desplegable != $valor_busqueda_seleccionado_listado){
	echo "<option value='".$valor_busqueda_seleccionado_listado."'>".$txt_mostrar_seleccionado_listado."</option>";
}
}

}


echo "</select>";

if($$permiso_popup="SI"){
echo '<a href="index.php?g=1&f='.$f_Popup.'&f1='.$f1_Popup.'&s1='.$s1_Popup.'&f_Padre='.$f.'&f1_Padre='.$f1.'&md5_Padre='.$num_objeto_md5.'&copio_Padre=SI&action='.$action_popup.'" rel="pop-up"><img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';
}

echo '</div>'; // FIN: contenedor campo ***********
}



// LISTADO DE DIAS ________________________________________________________________________		
function listado_dias()
	{
    echo "<option>01</option>
    <option>02</option>
    <option>03</option>
    <option>04</option>
    <option>05</option>
    <option>06</option>
    <option>07</option>
    <option>08</option>
    <option>09</option>
    <option>10</option>
    <option>11</option>
    <option>12</option>
    <option>13</option>
    <option>14</option>
    <option>15</option>
    <option>16</option>
    <option>17</option>
    <option>18</option>
    <option>19</option>
    <option>20</option>
    <option>21</option>
    <option>22</option>
    <option>23</option>
    <option>24</option>
    <option>25</option>
    <option>26</option>
    <option>27</option>
    <option>28</option>
    <option>29</option>
    <option>30</option>
    <option>31</option>";
	}


// LISTADO DE MESES ________________________________________________________________________		
function listado_meses()
	{
    echo "<option value='01'>ENERO</option>
    <option value='02'>FEBRERO</option>
    <option value='03'>MARZO</option>
    <option value='04'>ABRIL</option>
    <option value='05'>MAYO</option>
    <option value='06'>JUNIO</option>
    <option value='07'>JULIO</option>
    <option value='08'>AGOSTO</option>
    <option value='09'>SEPTIEMBRE</option>
    <option value='10'>OCTUBRE</option>
    <option value='11'>NOVIEMBRE</option>
    <option value='12'>DICIEMBRE</option>";
}

// LISTADO DE AÑOS ________________________________________________________________________		
function listado_years($intervaloYears)
	{
    if($intervaloYears=="2002_2015"){
	echo "<option>2002</option>
	<option>2003</option>
	<option>2004</option>
    <option>2005</option>
    <option>2006</option>
    <option>2007</option>
    <option>2008</option>
    <option>2009</option>
    <option>2010</option>
	<option>2011</option>
	<option>2012</option>
	<option>2013</option>
	<option>2014</option>
	<option>2015</option>";
	}


}


function veo_nombremes($m)
	{
	global $nombremes;

$nombremes="";

switch($m){
case "01": $nombremes="ENERO";
break;
case "02": $nombremes="FEBRERO";
break;
case "03": $nombremes="MARZO";
break;
case "04": $nombremes="ABRIL";
break;
case "05": $nombremes="MAYO";
break;
case "06": $nombremes="JUNIO";
break;
case "07": $nombremes="JULIO";
break;
case "08": $nombremes="AGOSTO";
break;
case "09": $nombremes="SEPTIEMBRE";
break;
case "10": $nombremes="OCTUBRE";
break;
case "11": $nombremes="NOVIEMBRE";
break;
case "12": $nombremes="DICIEMBRE";
break;
}
return $nombremes;
}
		
?>