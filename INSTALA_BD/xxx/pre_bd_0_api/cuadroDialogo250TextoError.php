<?php
	
echo '<div class="cuadrodialogoTextoError250">'; // INICIO: <div class="cuadrodialogo250">'

echo '<div class="cabeceracuadrodialogoTextoError250">';
	echo $tituloCuadroDialogo;
echo '</div>';

echo '<div class="cuerpocuadrodialogoTextoError250">';// INICIO: <div class="cuerpocuadrodialogo">
        echo $textoCuadroDialogo;//include("$includeCuadroDialogo");


echo '<div class="contenedorBotones">';// INICIO: <div class="contenedorBotones">
if(strlen(trim($urlBoton1))>0){
echo '<a href="'.$urlBoton1.'"><img src="'.$variableadmin_prefijo_bd.'imagenes/'.$imagenBoton1.'" alt="'.$titleBoton1.'" title="'.$titleBoton1.'" /></a>';
}
echo '</div>';// FIN: <div class="contenedorBotones">


echo '</div>';// FIN: <div class="cuerpocuadrodialogo">

echo '</div>'; // FIN: <div class="cuadrodialogo250">'
		
?>