<?php

include 'class/yaml/lib/sfYaml.php';

if (!isset($_GET['m']))
    die("USO: alterConfig.php?m=MODULO");

$module = $_GET['m'];
$fileName = "../Erp/modules/{$module}/config.yml";

if (!file_exists($fileName))
    die("NO EXISTE: {$fileName}");

$config = sfYaml::load($fileName);

// COLUMNAS
$columns = $config[$module]['columns'];
foreach ($columns as $column) {
    $field = $column['field'];
    unset($column['field']);
    $newColumns[$field] = $column;
}
$config[$module]['columns'] = $newColumns;

$yml = sfYaml::dump($config);
$fp = fopen($fileName."_", "w");
fwrite($fp, $yml);
fclose($fp);
