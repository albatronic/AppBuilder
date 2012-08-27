<?php
	
echo '<div class="cuadrodialogo250">'; // INICIO: <div class="cuadrodialogo250">'

echo '<div class="cabeceracuadrodialogo250">';
	echo $tituloCuadroDialogo;
echo '</div>';

echo '<div class="cuerpocuadrodialogo250">';// INICIO: <div class="cuerpocuadrodialogo">
        include("$includeCuadroDialogo");
echo '</div>';// FIN: <div class="cuerpocuadrodialogo">

echo '</div>'; // FIN: <div class="cuadrodialogo250">'
		
?>