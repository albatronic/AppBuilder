<?php

$inicio = date('H:i:s');

// URL A LA QUE SE HACE LA PETICION
//$url = "https://foxplaces.appspot.com/fox/foxfans";
$url = "https://foxplaces.appspot.com/fox/fans?userID=46001";
//$url = "http://www.albatronic.com/fox/foxws.php?id=" . $_GET['id'];

// Hago la petición y el resultado lo guardo en $resultado,
// que es un array con los elementos 'resultado' e 'info'
$resultado = getRequest($url);

$fin = date('H:i:s');

if ($resultado['info']['http_code'] != 200)
    die("ERROR in CALL: " . $resultado['info']['http_code']);

// Paso de formato Json a formato array php
$arrayResultado = json_decode($resultado['result'], true);

/**
 * Hace una peticion vía CURL a la url $url y obtiene el resultado
 * en un array que tiene dos elementos, en el elemento 'result'
 * está el resultado propiamente dicho en formato JSON y en el
 * elemento 'info' está el eventual código de error
 *
 * @param string $url La url con la peticion
 * @return array Array con dos elementos: result, info
 */
function getRequest($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    return array(
        'result' => $result,
        'info' => $info,
    );
}

function pintaNodo($array, $nodo) {
    foreach ($array[$nodo] as $item)
        echo "<img src='{$item['imageURL']}' />";
}
?>

<html>
    <body>

        LA RESPUESTA JSON AL REQUEST <?php echo $inicio, " ", $fin; ?>
        <pre><?php print_r($arrayResultado); ?></pre>

        <br />LAS IMAGENES DEL NODO 'global'
        <?php pintaNodo($arrayResultado, 'global'); ?>

        <br />LAS IMAGENES DEL NODO 'week'
        <?php pintaNodo($arrayResultado, 'week'); ?>

    </body>
</html>