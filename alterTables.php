<?php

/**
 * RECORRE LAS TABLAS DE LA BASE DE DATOS $db
 * Y EJECUTA SOBRE ELLAS TODAS LAS QUERYS DEFININAS
 * EN EL ARRAY $querys
 *
 * SI SE RECIBE UN VALOR DISTINTO DE '*' EN $_GET['t'] LAS QUERYS SE
 * EJECUTARAN SOLO EN ESE TABLA, SI EL VALOR ES '*' SE EJECUTARAN
 * EN TODAS LAS TABLAS
 *
 * SI SE INDICA EL PARÁMETRO config=1, se añadirá en en config.yml de la/s
 * tabla/s los parametros valores indicados en $config[]
 */

include 'class/yaml/lib/sfYaml.php';
$perfilesCpanel = array(
    'perfiles' => array('1'=>1,'2'=>2),
);
$perfilesCpanelYml = sfYaml::dump($perfilesCpanel);
$perfilesWeb = array(
    'perfiles' => array('1'=>1,),
);
$perfilesWebYml = sfYaml::dump($perfilesWeb);
$parametros = $_GET;

if (count($parametros) >= 5) {
    $ok = true;
    foreach ($parametros as $parametro)
        $ok = ($ok and ($parametro != ''));
} else
    $ok = false;

if (!$ok)
    die("USO: alterTables.php?h=HOST&u=USUARIO&p=PASSWORD&db=NOMBRE_DE_LA_BASE_DE_DATOS&t=[ NOMBRE_DE_LA_TABLA | * ]&config=[1 | 0]");

$querys[] = "update `TABLA` set ShowOnSitemap='1', ImportanceSitemap='0.5', ChangeFreqSitemap='daily'";
//$querys[] = "update `TABLA` set Privacy='2', UrlHeritable='0', AccessProfileListWeb='{$perfilesWebYml}'";
//$querys[] = "ALTER TABLE `TABLA` ADD `EsWiki` TINYINT(1) NOT NULL DEFAULT '0' AFTER `EsEvento`";
//$querys[] = "ALTER TABLE `TABLA` ADD `PrintedBy` INT(4) NOT NULL DEFAULT '0' AFTER `DeletedAt`";
//$querys[] = "ALTER TABLE `TABLA` ADD `PrintedAt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `PrintedBy`";
//$querys[] = "ALTER TABLE `TABLA` ADD `EmailedBy` INT(4) NOT NULL DEFAULT '0' AFTER `PrintedAt`";
//$querys[] = "ALTER TABLE `TABLA` ADD `EmailedAt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `EmailedBy`";
//$querys[] = "UPDATE TABLA SET Publish='1', ActiveFrom='0000-00-00 00:00:00', ActiveTo='0000-00-00 00:00:00', Privacy='0'";
//$querys[] = "ALTER TABLE `TABLA` ADD UNIQUE(`UrlFriendly`)";
//$querys[] = "ALTER TABLE  `TABLA` ADD  `Language` CHAR( 2 ) NOT NULL DEFAULT  'es' AFTER  `Id`";
//$querys[] = "ALTER TABLE `TABLA` ADD  `AccessProfileListWeb` VARCHAR(100)  NOT NULL DEFAULT '{$perfilesWebYml}' AFTER `AccessProfileList`";
//$querys[] = "ALTER TABLE `TABLA` CHANGE `AccessProfileList` `AccessProfileList` VARCHAR( 100 ) NOT NULL DEFAULT '{$perfilesCpanelYml}'";
//$querys[] = "ALTER TABLE `TABLA` CHANGE `AccessProfileListWeb` `AccessProfileListWeb` VARCHAR( 100 ) NOT NULL DEFAULT '{$perfilesWebYml}'";
//$querys[] = "UPDATE `TABLA` SET AccessProfileList='{$perfilesCpanelYml}',AccessProfileListWeb='{$perfilesWebYml}'";
//$querys[] = "delete  from `TABLA` where Id='2'";
//$querys[] = "ALTER TABLE `TABLA` CHANGE `Id` `Id` BIGINT( 11 ) NOT NULL AUTO_INCREMENT";
//$querys[] = "ALTER TABLE `TABLA` ADD `IdUsuario` BIGINT(11) NOT NULL COMMENT  'db,PcaeUsuarios,Id' AFTER `Id`, ADD UNIQUE(`IdUsuario`)";
//$querys[] = "update `TABLA` SET IdUsuario='1' where Id='1'";
//$query[] = "ALTER TABLE `TABLA` CHANGE `NivelJerarquico`  `NivelJerarquico` INT( 4 ) NULL DEFAULT  '1'";`
//$querys[] = "ALTER TABLE `TABLA` ADD `NivelJerarquico` INT(4) NULL DEFAULT '1' AFTER `RevisitAfter`";
//$querys[] = "ALTER TABLE `TABLA` ADD  `RevisitAfter` VARCHAR(20) NULL DEFAULT  NULL AFTER `DateTimeLastVisit`";
//$querys[] = "ALTER TABLE  `TABLA` ADD  `DateTimeLastVisit` BIGINT( 11 ) NOT NULL DEFAULT  '0',
//ADD INDEX (  `DateTimeLastVisit` );";
//$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb1` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb1`";
//$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb2` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb2`";
//$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb3` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb3`";
//$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb4` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb4`";
//$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb5` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb5`";
//$querys[] = "ALTER TABLE  `TABLA` ADD  `IsSuper` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  'Abstract,ValoresSN,IDTipo' AFTER  `IsDefault` ,
//ADD INDEX (  `IsSuper` );";

$config = array(
    'columna' => 'AccessProfileListWeb',
    'propiedades' => array(
        'title' => 'Perfiles Web',
        'filter' => 'NO',
        'list' => 'NO',
        'visible' => true,
        'updatable' => true,
        'default' => $perfilesWebYml,
    ),
);

echo "<pre>";
print_r($querys);
echo "</pre>";
$dbLink = mysql_connect($parametros['h'], $parametros['u'], $parametros['p']);
if ($dbLink) {
    $connectId = mysql_select_db($parametros['db'], $dbLink);
    if ($connectId) {

        if ($parametros['t'] == '*') {
            $query = "SHOW TABLES";
            $result = mysql_query($query);
            while ($row = mysql_fetch_array($result))
                $rows[] = $row;
        } else
            $rows[][0] = $parametros['t'];

        foreach ($rows as $row) {
            foreach ($querys as $query) {
                $query = str_replace("TABLA", $row[0], $query);echo $query,"</br>";
                $ok = mysql_query($query);
            }
            if ($parametros['config'] == '1')
                cambiaConfig($row[0], $config);
            echo $row[0], " {$ok}<br/>";
        }

        mysql_close($dbLink);
    } else {
        echo "NO SE HA ESTABLECIDO CONEXION CON LA BASE DE DATOS '{$parametros['db']}'";
    }
} else {
    echo "NO SE HA ESTABLECIDO CONEXION CON EL SERVIDOR";
}

function cambiaConfig($tabla, array $config)
{
    $tabla = ucfirst($tabla);
    $file = "../Cpanel/modules/{$tabla}/config.yml";
    echo $file, "<br/>";
    if (file_exists($file)) {
        $datos = sfYaml::load($file);
        $datos[$tabla]['columns'][$config['columna']] = $config['propiedades'];
        $yml = sfYaml::dump($datos, 4);
        $fp = fopen($file, "w");
        if ($fp) {
            fwrite($fp, $yml);
            fclose($fp);
        }
    }
}
