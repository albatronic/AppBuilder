<?php

$con = mysql_connect("formulacapitalgranada.es", "fcg_albatro", "F12#34g");
if ($con) {
    echo "conecto";
    $a = mysql_select_db("qse042");
    if ($a) {
        $res = mysql_query("select * from ErpUsuarios");echo $res;
        while ($row = mysql_fetch_array($res)) print_r($row);
        echo "fin";
    } else die("error select db");
} else
    echo mysql_error();

exit;

function iban($cc, $codigoPais = "ES") {
    echo ord($codigoPais[0]),ord($codigoPais[1])," ";
    $dividendo = $cc . (ord($codigoPais[0]) - 55) . (ord($codigoPais[1]) - 55) . '00';
    $digitoControl = 98 - bcmod($dividendo, '97');
    if (strlen($digitoControl) == 1) {
        $digitoControl = '0' . $digitoControl;
    }

    return $codigoPais . $digitoControl . $cc;
}

echo iban("00303029880003814272");

exit;

try {
    $con = new PDO("mysql:host=localhost;dbname=albatro_demo", "root", "root");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Erro conexión: " . $ex->getMessage();
}

$stmt = $con->prepare("select * from ErpFamilias");
$stmt->execute();
while ($objeto = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($objeto);
}

exit;

function digitoControlPresentador($cif) {
    $cif = $cif . "ES00";
    $resultado = "";
    for ($i = 0; $i < strlen($cif); $i++) {
        $a = $cif[$i];
        $b = (ord($a) > 64) ? ord($a) - 55 : $a;
        $resultado .= $b;
    }

    $digitoControl = 98 - bcmod($resultado, '97');
    if (strlen($digitoControl) == 1) {
        $digitoControl = '0' . $digitoControl;
    }

    return $digitoControl;
}

$array = array('E18924266', '23370679B', '24135975M', '24207607S', '24295232X', 'B18040451', 'E18294181');
foreach ($array as $cif) {
    echo $cif, " => ", digitoControlPresentador($cif), "<br/>";
}

exit;



header('Content-Type: application/xml; charset=utf-8');
error_reporting(E_ALL);
error_reporting(-1);

include 'SepaXml19.class.php';

$array = array(
    'header' => array(
        'id' => 'S1914/11/20140215',
        'fecha' => date('Y-m-d') . "T" . date('H:i:s'),
        'fechaCargo' => '2014-02-28',
        'nRecibos' => 1,
        'total' => '234.58',
        'razonSocial' => 'Informatica Albatronic, SL',
        'direccion1' => 'Avd. Blas Otero, 10 Local 1',
        'direccion2' => '18200 Maracena Granada',
        'cif' => 'ES00B18426684',
        'iban' => 'ESxx21002497190210004796',
        'bic' => 'CAIXESBB',
    ),
    'recibos' => array(
        0 => array(
            'numeroFactura' => 'FA001',
            'importe' => '1500.23',
            'idMandato' => 'mandato1',
            'fechaMandato' => '2013-02-01',
            'bic' => 'BIC001',
            'iban' => 'ESXXBBBBOOOODDCCCCCCCCCC',
            'razonSocial' => 'PRIMER CLIENTE, SL',
            'direccion1' => 'calle',
            'direccion2' => 'poblacion',
            'pais' => 'ES',
            'texto' => 'Factura N. FA001 10-01-2014 1500.23€',
        ),
        1 => array(
            'numeroFactura' => 'FA002',
            'importe' => '500.99',
            'idMandato' => 'mandato2',
            'fechaMandato' => '2013-02-02',
            'bic' => 'BIC002',
            'iban' => 'ESXXBBBBOOOODDCCCCCCCCCC',
            'razonSocial' => 'SEGUNDO CLIENTE, SL',
            'direccion1' => 'calle',
            'direccion2' => 'poblacion',
            'pais' => 'EN',
            'texto' => 'Factura N. FA002 11-01-2014 500.99€',
        ),
    ),
);
SepaXml19::makeDocument("sepa19Text.xml", $array);
exit;


