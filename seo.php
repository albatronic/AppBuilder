<?php

class seo {

    var $content;
    var $url;

    public function __construct($url) {
        $this->url = $url;
        $this->setContent();
    }

    public function getContent() {
        return $this->content;
    }

    public function getType() {

        if (strpos($this->content, "<html") || strpos($this->content, "<HTML")) {
            $tipo = "html";
        } elseif (strpos($this->content, "<?urlset", 0) || strpos($this->content, "<?XML", 0)) {
            $tipo = "xml";
        } else {
            $tipo = "otro";
        }

        return $tipo;
    }

    public function getMeta($item) {

        $valor = "";

        $textoBusqueda = "<meta name=\"{$item}\" content=";
        $long = strlen($textoBusqueda);
        //echo $textoBusqueda;
        $posInicio = strpos($this->content, $textoBusqueda);
        if (!$posInicio) {
            $textoBusqueda = strtolower($textoBusqueda);
            $posInicio = strpos($this->content, $textoBusqueda);
        }
        if ($posInicio) {
            $posInicio += strlen($textoBusqueda) + 1;
            $posFin = strpos($this->content, '"', $posInicio);
            $valor = substr($this->content, $posInicio, $posFin - $posInicio);
        }

        //echo $posInicio," ",$posFin;
        return $valor;
    }

    public function getRobots() {
        $robots = file_get_contents($this->url . "/robots.txt");
        return $robots;
    }

    private function setContent() {
        $this->content = file_get_contents($this->url);
    }

}

$url = $_GET['u'];
$content = file_get_contents($url);

if ($url !== '') {
    $seo = new seo($url);
    $resultado = array(
        'url' => $url,
        'tipo' => $seo->getType(),
        'Meta Description' => $seo->getMeta("Description"),
        'Meta Keywords' => $seo->getMeta("Keywords"),
    );
    pintaResultado($resultado);
    echo $seo->getRobots();
} else {
    die("USAGE: seo.php?u=URL");
}

function pintaResultado($array) {
    echo "<table>";
    foreach ($array as $key => $value) {
        echo "<tr><td>{$key}</t><td>{$value}</td></tr>";
    }
    echo "</table>";
}
