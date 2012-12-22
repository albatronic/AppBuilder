<?php

include "class/Ftp.class.php";
include "class/yaml/lib/sfYaml.php";

//$ftp = new Ftp('www.ecoclimagranada.com', 'sdc4448', 'Rosa2011');
//$ok = $ftp->upload('html/imagenes', 'dd_cpanel.pdf', 'a.pdf');
//$ok = $ftp->rename('html/imagenes', 'a.pdf', 'aa.pdf');
//$ok = $ftp->delete('html/imagenes', 'aa.pdf');
//$ftp = new Ftp('www.albatronic.com', 'albatro', 'p17s26a26');
//$ok = $ftp->upload('public_ftp', '../kaia/config/varMod_EnlSecciones_Env.yml', 'varMod_EnlSecciones_Env.yml');
//if (!$ok)
//    print_r($ftp->getErrores());
//unset($ftp);
//$ok = $ftp->downLoad('public_html/Erp/config/config.yml', '../config.yml');
//if (!$ok)
//    print_r($ftp->getErrores());
//else {
//    $yml = sfYaml::load('../config.yml');
//    print_r($yml);
//}
//unset($ftp);


$connectId = ftp_connect('192.168.1.38');
if ($connectId) {
    $ok = ftp_login($connectId, 'sergio', 'E123456L');
    if ($ok) {
        echo "directorio actual ", ftp_pwd($connectId),"<br />";
        //$ok = ftp_mkdir($connectId, 'public_html/docs/sergio');
        //echo $ok;
    }
}

$dbLink = mysql_connect('192.168.1.38','regantes','regantes');
echo "conexion db ",$dbLink;
?>

