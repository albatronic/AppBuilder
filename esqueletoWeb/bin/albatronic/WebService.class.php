<?php

/**
 * Description of WebService
 *
 * @author sergio
 */
class WebService {

    static function getOrigenVisitante($webService) {

        $resultado = self::getRequest($webService);
        $array = explode(",", $resultado['result']);

        foreach ($array as $key => $value)
            $array[$key] = str_replace('"', '', $value);

        return array(
            'Host' => $array[0],
            'IpAddress' => $array[1],
            'CodigoPais' => $array[2],
            'NombrePais' => $array[3],
            'CodigoRegion' => $array[4],
            'NombreRegion' => $array[5],
            'Ciudad' => $array[6],
            'CodigoPostal' => $array[7],
            'Latitud' => $array[8],
            'Longitud' => $array[9],
            'ISP' => $array[10],
            'Organizacion' => $array[11],
        );
    }

    /**
     * Hace una peticion vía CURL a la url $url y obtiene el resultado
     * en un array que tiene dos elementos, en el elemento 'result'
     * está el resultado propiamente dicho en formato JSON y en el
     * elemento 'info' está el eventual código de error
     *
     * @param string $url La url con la peticion
     * @param string $metodo El método de peticion: GET ó POST, por defecto GET
     * @param string $parametrosPost Los eventuales parametros post en formato: nombre1=valor1&nombre2=valor2
     * @return array Array con dos elementos: result, info
     */
    static function getRequest($url, $metodo = 'GET', $parametrosPost = '') {

        $metodo = strtoupper($metodo);

        if (!in_array($metodo, array('GET', 'POST')))
            $metodo = 'GET';

        $options = array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => FALSE,
        );

        if ($metodo == 'POST') {
            $options['CURLOPT_POST'] = 1;
            $options['CURLOPT_POSTFIELDS'] = $parametrosPost;
        }

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

}

?>
