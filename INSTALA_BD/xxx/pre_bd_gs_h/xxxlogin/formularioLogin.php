<?php

$_SESSION['grabar_bd']=0;

echo '<form name="form_login" method="post" action="index.php">';
//echo '<input type="hidden" name="i" value="1">';
echo '<input type="hidden" name="login" value="1">';
echo '<input type="hidden" name="f" value="'.$f.'">';
//echo '<input type="hidden" name="c" value="'.$c.'">';
echo '<input type="hidden" name="f1" value="'.$f1.'">
<input type="hidden" name="s1" value="resultadoLogin">';


echo '<div class="filaformulario">'; // INICIO: <div class="filaformulario">
	echo '<span class="etiqueta_90">Usuario:</span>';
	echo '<input type="password" name="usuario" value="" class="campotexto_145" /> ';
echo '</div>'; // FIN: <div class="filaformulario">

echo '<div class="filaformulario">'; // INICIO: <div class="filaformulario">
	echo '<span class="etiqueta_90">Contrase&ntilde;a:</span>';
	echo '<input type="password" name="password" value="" class="campotexto_145" /> ';
echo '</div>'; // FIN: <div class="filaformulario">

echo '<div class="filaformulario_alignright">'; // INICIO: <div class="filaformulario_alignright">
echo '<input type="image" src="'.$variableadmin_prefijo_bd.'imagenes/btn_aceptar2.jpg">';
//echo '<img src="imagenes/btn_aceptar2.jpg" />';
echo '</div>'; // FIN: <div class="filaformulario_alignright">

?>