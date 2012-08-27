<?php

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

input_radio_dos_opciones_submit("spam_margin_10","PARTICULAR","EMPRESA","Persona F&iacute;sica","Empresa","tipo");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

input_text_generico("etiqueta_150","campotexto_205","Nombre:","nombre");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

input_text_generico("etiqueta_150","campotexto_205","Apellido1:","apellido1");
input_text_generico("etiqueta_140","campotexto_205","Apellido2:","apellido2");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

if($tipo=="PARTICULAR"){$etiqueta="D.N.I.:";}else{$etiqueta="C.I.F.:";}
input_text_generico("etiqueta_150","campotexto_205",$etiqueta,"nif_cif");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________



echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

$etiqueta="Fecha Nacimiento:"; $campoauditar="fech_nacimiento"; $estiloEtiqueta="etiqueta_150"; $estiloCampo="spam_campotexto_205"; $intervaloYears="2002_2015";
$ruta = $variableadmin_prefijo_bd.'0_camposFormulario/campoFecha.php'; include("$ruta");

$etiqueta="Primera Alta:"; $campoauditar="fech_primera_alta"; $estiloEtiqueta="etiqueta_140"; $estiloCampo="spam_campotexto_205"; $intervaloYears="2002_2015";
$ruta = $variableadmin_prefijo_bd.'0_camposFormulario/campoFecha.php'; include("$ruta");





echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

echo '<div class="spam_margin_10">';
checkbox_etiqueta_derecha("rojo","Rojo"); echo '&nbsp;&nbsp;&nbsp;';
checkbox_etiqueta_derecha("azul","Azul"); echo '&nbsp;&nbsp;&nbsp;';
checkbox_etiqueta_derecha("amarillo","Amarillo"); echo '&nbsp;&nbsp;&nbsp;';
echo '</div>';

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


// FILA CON EL CAMPO TEXTAREA
textarea_fila_completa("Observaciones:","observaciones","filaformulario","filaformularioEspacioAbajo","textarea900x100");



?>