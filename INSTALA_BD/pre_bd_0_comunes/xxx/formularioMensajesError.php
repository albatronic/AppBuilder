<?php

echo '<div class="filaformularioMensajesError">';
foreach ($arrayDeErroresFormulario as $i => $value) {
    echo $value,' <img src="'.$variableadmin_prefijo_bd.'imagenes/error_formulario.jpg" alt="'.$value.'" title="'.$value.'" /><br/>';
/*$dato=$value;
$sql="insert into $nombre_tabla (id_urlsreservadas,url_amigable) values(null, '$dato')";
$res=mysql_query($sql,$db); */

}
echo '</div>';

?>