<?php
if(strlen($Campo1_explode[6])<2){$Campo1_explode[6]=$FuncionalidadesDefault;}
//echo "<br>Campo1_explode[7]: ",$Campo1_explode[7],"<br>";
//if($Campo1_explode[7]!=1){$Campo1_explode[7]=0;}else{$Campo1_explode[7]=1;}
//echo "<br>Campo1_explode[7]: ",$Campo1_explode[7],"<br>";

//CodigoApp bigint(11) | NombreModulo varchar(255) | PerteneceA varchar(255) | Nivel int(4) | Titulo varchar(100) | Descripcion varchar(100) | Funcionalidades varchar(255) | Publicar tinyint(1)

$CodigoApp="'".trim($Campo1_explode[0])."'";
$NombreModulo="'".trim($Campo1_explode[1])."'";
$Nivel="'".trim($Campo1_explode[3])."'";
$PerteneceA="'".trim($Campo1_explode[2])."'";
$Titulo="'".trim($Campo1_explode[4])."'";
$Descripcion="'".trim($Campo1_explode[5])."'";
$Funcionalidades="'".trim($Campo1_explode[6])."'";
$Publicar="'".trim($Campo1_explode[7])."'";
//echo "<br>Publicar: ",$Publicar,"<br>";

?>