<?php

echo '<a href="index.php?g=1&f='.$variableadmin_prefijo_bd.'gs_h">Inicio</a>';

echo ' > ';
echo '<a href="index.php?g=1&f='.$f.'">Terceros</a>';


if($s1=="0_menu_principal"){
echo ' > Terceros';
}

if($s1=="0_nuevo"){
echo ' > ';

echo '<a href="index.php?g=1&f='.$f.'&f1=t_terceros">Terceros</a>';

echo ' > Nuevo';
}


if($s1=="0_formulario"){
echo ' > ';

echo '<a href="index.php?g=1&f='.$f.'&f1=t_terceros">Terceros</a>';

echo ' > Formulario';
}

?>
