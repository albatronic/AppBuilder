<?php

//setlocale(LC_ALL, 'it_IT');
//echo strftime("%A %d %B %Y", mktime(0, 0, 0, 12, 22, 1978));

$a = array(
    'id' => array(
        'a' => 'hola',
        'b' => 'adios',
    ),
    //'nombre' => array(
        //'aaa' => 'j',
    //),
);

$b = array(
    'id' => array(
        'a' => 'hola',
        'b' => 'adios',
        'c' => 'buenas',
    ),
    'nombre' => array(),
);
echo "Igualdad: ",($a === $b);
echo "<pre>";
print_r(array_diff_assoc($a,$b));
echo "</pre>";

echo str_pad(trim("02"), 10, "0");
