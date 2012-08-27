<?php
if($esdatopredeterminado!="SI"){
echo '<a href=""><img src="'.$variableadmin_prefijo_bd.'imagenes/papelera_18.jpg" alt="" title="" /></a>';
}else{
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/espacio18x18.gif" alt="" title="" />';
}

echo '<a href="index.php?g=1&f='.$f.'&f1='.$f1.'&s1=0_formulario&pag='.$anterior.'&orden='.$orden.'&criterio='.$criterio.'&action=list&num_objeto_md5='.$num_objeto_md5.'&vengode=listado">';
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/lupa.jpg" alt="" title="" /></a>';

if($copio_Padre=="SI"){
if(strlen(trim($md5_Padre))>0){
echo '<a href="index.php?g=1&f='.$f.'&f1='.$f1.'&s1='.$s1.'&pag='.$pag.'&orden='.$orden.'&criterio='.$criterio.'&action='.$action.'&num_objeto_md5='.$num_objeto_md5.'&vengode='.$vengode.'&f_Padre='.$f_Padre.'&f1_Padre='.$f1_Padre.'&md5_Padre='.$md5_Padre.'&copio_Padre='.$copio_Padre.'&run_copy=SI">';
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';
}
}

//echo '<a href="index.php?g=1&f='.$f_Popup.'&f1='.$f1_Popup.'&s1='.$s1_Popup.'&f_Padre='.$f.'&f1_Padre='.$f1.'&md5_Padre='.$num_objeto_md5.'&copio_Padre=SI" rel="pop-up"><img src="'.$variableadmin_prefijo_bd.'imagenes/copiar-formulario-padre.png" alt="" title="" /></a>';

?>