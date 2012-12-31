<?php

$url = 'http://www.google.es/imgres?q=orquesta+de+c%C3%A1mara&hl=es&tbo=d&biw=800&bih=476&tbm=isch&tbnid=WICDWLb0M9Rf-M:&imgrefurl=http://www.articoestudio.com/web-de-la-orquesta-de-camara-andaluza.php&docid=lZFDNMfAPs0uqM&imgurl=http://www.articoestudio.com';

$array = parse_url($url);
$arrayQuery = parse_str($array['query'],$output);

$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
$host     = $_SERVER['HTTP_HOST'];
$script   = $_SERVER['SCRIPT_NAME'];
$params   = $_SERVER['QUERY_STRING'];
 
$url = $protocol . '://' . $host . $script . '?' . $params;
 
echo $url,"<BR />";

echo $output['q'],"<BR />";
print_r($array);
print_r($output);


exit;

$inicio = date('H:i:s');

// URL A LA QUE SE HACE LA PETICION
$url = "http://www.albatronic.com/ws/ws.php";

// Hago la petición y el resultado lo guardo en $resultado,
// que es un array con los elementos 'resultado' e 'info'
$parametros= $_GET;//"t=clientes&c=RazonSocial,Direccion,Poblacion";
$resultado = getRequest($url,$parametros);

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
function getRequest($url, $parametros) {

    $options = array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HEADER => FALSE,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $parametros,
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
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

    </body>
</html>