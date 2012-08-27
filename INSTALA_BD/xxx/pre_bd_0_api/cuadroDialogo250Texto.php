<?php
	
echo '<div class="cuadrodialogoTexto250">'; // INICIO: <div class="cuadrodialogo250">'

echo '<div class="cabeceracuadrodialogoTexto250">';
	echo $tituloCuadroDialogo;
echo '</div>';

echo '<div class="cuerpocuadrodialogoTexto250">';// INICIO: <div class="cuerpocuadrodialogo">
        echo $textoCuadroDialogo;//include("$includeCuadroDialogo");


echo '<div class="contenedorBotones">';// INICIO: <div class="contenedorBotones">
if(strlen(trim($urlBoton1))>0){
echo '<a href="'.$urlBoton1.'"><img src="'.$variableadmin_prefijo_bd.'imagenes/'.$imagenBoton1.'" alt="'.$titleBoton1.'" title="'.$titleBoton1.'" /></a>';
}
if(strlen(trim($urlBoton2))>0){
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/espacio5.gif" alt="" title="" />';
echo '<a href="'.$urlBoton2.'"><img src="'.$variableadmin_prefijo_bd.'imagenes/'.$imagenBoton2.'" alt="'.$titleBoton2.'" title="'.$titleBoton2.'" /></a>';
}

echo '</div>';// FIN: <div class="contenedorBotones">


echo '</div>';// FIN: <div class="cuerpocuadrodialogo">

echo '</div>'; // FIN: <div class="cuadrodialogo250">'

		
?>