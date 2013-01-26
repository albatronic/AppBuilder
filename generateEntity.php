<?php
/* 
 * Genera la clase de una entidad
 */

if(!isset($_GET['t']))
    die("generateEntity.php?t=tablename");

$database_connection_information = "
define(DB_HOST,'localhost');
define(DB_USER,'root');
define(DB_PASS,'');
define(DB_BASE,'interpra_ppuerp001');
define(PATH_MODEL,'../erp/entities');
";
eval($database_connection_information);

$tablename=$_GET['t'];

include "class/tabledescriptor.class.php";
include "class/entitybuilder.class.php";
include "class/CreaFichero.class.php";

$dblink = mysql_connect(DB_HOST,DB_USER,DB_PASS);
mysql_select_db(DB_BASE,$dblink);
$td=new tabledescriptor(DB_BASE,$tablename);

$filename=str_replace("_", " ", strtolower($tablename));
$filename=str_replace(" ","",ucwords($filename));
$entity = new EntityBuilder($tablename);
new CreaFichero(PATH_MODEL."/models/".$filename.".class.php", $entity->GetModel());
new CreaFichero(PATH_MODEL."/methods/".$filename.".class.php", $entity->GetMethod());
mysql_close($dblink);

echo $entity->Get();
?>

