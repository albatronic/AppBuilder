<?php



// *******************
$actual=$pag;
$siguiente=$pag+1;
$anterior=$pag-1;

if($actual==1 or $actual==0){
}else{
echo "<a href='index.php?g=1&f=$f&f1=$f1&s1=$s1&pag=$anterior&orden=$orden&criterio=$criterio'>";
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/btn_anterior.jpg" alt="" title="" />';
echo "</a>";


}
if($actual==$total_pags){
}else{
echo "<a href='index.php?g=1&f=$f&f1=$f1&s1=$s1&pag=$siguiente&orden=$orden&criterio=$criterio'>";
echo '<img src="'.$variableadmin_prefijo_bd.'imagenes/btn_siguiente.jpg" alt="" title="" />';
echo "</a>";

}

?>