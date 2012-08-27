<?php

$sqlinsert="insert into $nombre_tabla (id_opcion,num_opcion,id_nivel,pertenece_a,txtmostrar,descripcion,enlace,posicion,mostrar,es_opcion_super,ordenenelmenu,mostrarenellistadodeopciones) values(null, '$id_opcion', '$nivel', '$pertenece_a', '$opcion', '$descripcion', '$enlace', '$posicion', '$mostraropcion', '$es_opcion_super', '$ordenenelmenu', '$mostrarenellistadodeopciones')";
$resinsert=mysql_query($sqlinsert,$db);


if($resinsert){
echo 'LA OPCIÓN <b>'.$opcion.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR LA OPCIÓN <b>'.$opcion.'</b> </font><br>';
}

?>

