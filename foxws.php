<?php

$response = Array(
    'global' => Array
        (
        '0' => Array
            (
            'userID' => 37012,
            'name' => 'Carmen García',
            'imageURL' => 'http://graph.facebook.com/100003999127433/picture',
            'place' => 'Desconocido',
            'points' => '1240',
            'position' => 1,
        ),
        '1' => Array
            (
            'userID' => '35022',
            'name' => 'Jose Manuel Aizpurua',
            'imageURL' => 'http://graph.facebook.com/1059996084/picture',
            'place' => 'Desconocido',
            'points' => 240,
            'position' => 2,
        ),
        '2' => Array
            (
            'userID' => 44012,
            'name' => 'Julio Galvez',
            'imageURL' => 'http://graph.facebook.com/711169482/picture',
            'place' => 'Madrid',
            'points' => 210,
            'position' => 3,
        ),
    ),
);

$id = $_GET['id'];

if ($id != '')
    $respuesta = $response['global'][$id];
else
    $respuesta = $response;

echo json_encode($respuesta);
?>
