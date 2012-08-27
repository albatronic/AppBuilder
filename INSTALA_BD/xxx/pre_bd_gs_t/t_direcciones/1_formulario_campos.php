<?php
/*
echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_generico_submit("etiqueta_180","campotexto_205","Pa&iacute;s:","id_pais","id_pais","pais","t_paises","NO","select_205");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_generico_submit_popup("etiqueta_180","campotexto_235","Pa&iacute;s:","id_pais","id_pais","pais","t_paises","NO","select_205","pre_bd_gs_t","t_paises","0_formulario","permiso_insert_t_paises","ins");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

/*
echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_generico_submit("etiqueta_180","campotexto_205","Pa&iacute;s:","id_pais","id_pais","pais","t_paises","NO","select_205");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

/*
echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_dependiente_submit_campo_vacio("etiqueta_180","campotexto_205","Provincia:","id_provincia","id_provincia","provincia","t_provincias","NO","select_205","id_pais","id_pais");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_generico_submit_popup("etiqueta_180","campotexto_235","Provincia:","id_provincia","id_provincia","provincia","t_provincias","NO","select_205","pre_bd_gs_t","t_provincias","0_formulario","permiso_insert_t_provincias","ins");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_dependiente_submit_campo_vacio_popup("etiqueta_180","campotexto_235","Provincia:","id_provincia","id_provincia","provincia","t_provincias","NO","select_205","id_pais","id_pais","pre_bd_gs_t","t_provincias","0_formulario","permiso_insert_t_provincias","ins");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

/*
echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_dependiente_dosvalores_submit_campo_vacio("etiqueta_180","campotexto_205","Localidad:","id_localidad","id_localidad","localidad","t_localidades","NO","select_205","id_provincia","id_provincia","id_pais","id_pais");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_dependiente_dosvalores_submit_campo_vacio_popup("etiqueta_180","campotexto_235","Localidad:","id_localidad","id_localidad","localidad","t_localidades","NO","select_205","id_provincia","id_provincia","id_pais","id_pais","pre_bd_gs_t","t_localidades","0_formulario","permiso_insert_t_localidades","ins");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

/*
echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_generico("etiqueta_90","campotexto_205","Tipo de V&iacute;a:","id_tiposdevias","id_tiposdevias","tiposdevia","t_tiposdevias","NO","select_205");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_dependiente_submit_campo_vacio("etiqueta_180","campotexto_205","V&iacute;a:","id_vias","id_vias","nombrecompletovia","t_vias","NO","select_205","id_localidad","id_localidad");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________





echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","N&uacute;mero:","numero_dela_via");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Km:","km");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Edificio:","nombre_edificio");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Bloque:","bloque");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Portal:","portal");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Escalera:","escalera");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Planta:","planta");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Puerta:","puerta");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Urbanizaci&oacute;n:","urbanizacion");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","C&oacute;digo Postal:","codigopostal");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
input_text_generico("etiqueta_180","campotexto_205","Informaci&oacute;n Adicional:","informacion_adicional");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


// FILA CON EL CAMPO TEXTAREA
textarea_fila_completa("Observaciones:","observaciones","filaformulario","filaformularioEspacioAbajo","textarea500x100");

/*
$f_Popup="pre_bd_gs_t";
$f1_Popup="t_paises";
$s1_Popup="0_listado";

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
echo $id_pais;
echo '<a href="index.php?g=1&f='.$f_Popup.'&f1='.$f1_Popup.'&s1='.$s1_Popup.'&f_Padre='.$f.'&f1_Padre='.$f1.'&md5_Padre='.$num_objeto_md5.'&copio_Padre=SI" rel="pop-up"><img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

/*
echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________
select_popup_generico("etiqueta_180","campotexto_205","Pa&iacute;s:","id_pais","pre_bd_gs_t","t_paises","0_listado","id_pais","pais","t_paises");
echo '</div>'; // FIN: FILA FORMULARIO _________________________________________
*/

//function select_popup_generico($classEtiqueta,$classCampo,$etiqueta,$campoauditar,$f_Popup,$f1_Popup,$s1_Popup,$campo_id_tabla_relacionada,$texto_mostrar_tabla_relacionada,$tabla_relacionada)

?>