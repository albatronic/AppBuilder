<?php




$sql="select $variablesubmodulo_nombre_campo_id from $name_tabla where id_localidad='$id_localidad' and id_provincia='$id_provincia' and id_pais='$id_pais' and id_tiposdevias='$id_tiposdevias' and $campoRepetido='".$$campoRepetido."' and $variablesubmodulo_nombre_campo_md5<>'$num_objeto_md5' and eliminado='NO'";
?>
