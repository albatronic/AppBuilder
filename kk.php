<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include "../erp/bin/spyc-0.5/Spyc.class.php";
include "../erp/bin/nimbus/XmlRead.class.php";
include "../erp/bin/xml/XmlTools.class.php";

$file = "../erp/modules/Articulos/config.xml";
$target = "../erp/modules/Articulos/config.yaml";

$dir = opendir('../erp/modules');
while ($carpeta = readdir($dir)) {
    if (($carpeta != '..') and ($carpeta != '.')) {
        $file = "../erp/modules/" . $carpeta . "/config.xml";
        $target = "../erp/modules/" . $carpeta . "/config.yml";

        cambia($file, $target, $carpeta);

        $file = "../erp/modules/" . $carpeta . "/listados.xml";
        $target = "../erp/modules/" . $carpeta . "/listados.yml";

        cambia($file, $target, $carpeta);
    }
}

function cambia($file, $target, $carpeta) {

    if (file_exists($file)) {

        echo $file,"</br>";
        
        $xml = new XmlTools();
        $arrayXml = $xml->Xml2Array($file);

        $yml = Spyc::YAMLDump($arrayXml);
        $yml = "# Module: ".$carpeta."\n#\n# @author: Sergio Perez <sergio.perez@albatronic.com>\n# @copyright: Informatica ALBATRONIC\n# @date: ".date('d-m-Y')."\n#\n".$yml;
        file_put_contents($target, $yml);
    }
}

/**
  $xml = new XmlTools();
  $arrayXml = $xml->Xml2Array($file);

  $yml = Spyc::YAMLDump($arrayXml);
  file_put_contents($target, $yml);

  echo "FORMATO YAML</br>";
  echo '<pre>';
  echo $yml;
  echo '</pre>';

  echo "FORMATO ARRAY</br>";
  echo '<pre>';
  print_r($arrayXml);
  echo '</pre>';
 */
?>
