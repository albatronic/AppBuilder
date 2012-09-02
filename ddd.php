<?php
include_once "class/tabledescriptor.class.php";
include_once "../apps/bin/pdf/fpdf.class.php";

class listadoPDF extends FPDF {

    //Cabecera de página
    function Header() {
        global $tableName;
        global $pintarEstado;

        switch ($pintarEstado) {
            case 'tables':
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, "Data Base: " . DB_BASE, 0, 1, "R");
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 5, "DATA DICTIONARY", 0, 1, "C");
                $this->Cell(0, 5, "Table: " . $tableName, 0, 1, "L");
                $this->Ln(5);
                $this->SetFont('Arial', '', 8);
                $this->Cell(30, 4, "Field");
                $this->Cell(12, 4, "Type");
                $this->Cell(7, 4, "Null");
                $this->Cell(7, 4, "Key");
                $this->Cell(10, 4, "Length");
                $this->Cell(15, 4, "Values");
                $this->Cell(15, 4, "Default");
                $this->Cell(25, 4, "Extra");
                $this->Cell(28, 4, "ReferencedSchema");
                $this->Cell(28, 4, "ReferencedEntity");
                $this->Cell(28, 4, "ReferencedColumn");
                break;
            case 'index':
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, "Data Base: " . DB_BASE, 0, 1, "R");
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, "DATA DICTIONARY - INDEX OF TABLES", 0, 1, "C");
                $this->Ln(10);
                $this->SetFont('Arial', '', 10);
                $this->Cell(70, 4, "Table", 0, 0, "C");
                $this->Cell(10, 4, "Page", 0, 0, "C");
                break;
            case 'dependenciesTo':
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, "Data Base: " . DB_BASE, 0, 1, "R");
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, "DATA DICTIONARY - REFERENCIES TO", 0, 1, "C");
                $this->Ln(10);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(70, 4, "Table", 0, 0, "C");
                $this->Cell(10, 4, "Referenced Entity", 0, 0, "C");
                break;
            case 'dependenciesFrom':
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, "Data Base: " . DB_BASE, 0, 1, "R");
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, "DATA DICTIONARY - DEPENDENCIES FROM", 0, 1, "C");
                $this->Ln(10);
                $this->SetFont('Arial', '', 10);
                $this->Cell(70, 4, "Source", 1, 0, "C", 1);
                $this->Cell(130, 4, "Target", 1, 1, "C", 1);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(40, 4, "Table");
                $this->Cell(30, 4, "Column");
                $this->Cell(40, 4, "Schema");
                $this->Cell(30, 4, "Table");
                $this->Cell(30, 4, "Entity");
                $this->Cell(30, 4, "Column");
                break;
        }
        $this->SetFont('Arial', '', 8);

        if ($pintarEstado != 'portada') {
            $this->Ln();
            $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 200, $this->GetY());
        }
    }

    //Pie de pagina
    function Footer() {
        global $sinPie;

        $this->SetFont('Arial', '', 8);
        $this->SetXY(10, -10);
        $this->Cell(50, 4, "Data Base: " . DB_BASE, 0, 0, "L");

        if (!$sinPie) {
            $pagina = $this->PageNo();
            $this->Cell(70, 4, date('d/m/Y H:i:s') . " Pag. " . $pagina . '/{nb}', 0, 0, "R");
            $this->Cell(0, 4, "@ Albatronic", 0, 0, "R");
        }
    }

}

if ($_POST['accion'] == 'BUILD') {
    if (!isset($_GET['dbase']) and !isset($_POST['table'])) die ("DEBE INDICAR UNA BASE DE DATOS");

    $database_connection_information = "
        define(DB_HOST,'" . $_POST[dbhost] . "');
        define(DB_USER,'" . $_POST[dbuser] . "');
        define(DB_PASS,'" . $_POST[dbpassword] . "');
        define(DB_BASE,'" . $_POST[dbase] . "');
        define(TABLE,'" . $_POST[table] . "');";

    eval($database_connection_information);

    $dblink = mysql_connect($_POST[dbhost], $_POST[dbuser], $_POST[dbpassword]);
    mysql_select_db($_POST[dbase], $dblink);

    if ($_POST['table'] == '') {
        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $_POST[dbase] . "'";
        $result = mysql_query($query, $dblink);
        while ($row = mysql_fetch_array($result))
            $tables[] = $row;
    } else {
        $tables[] = array('0' => $_POST['table'], 'TABLE_NAME' => $_POST['table']);
    }

    $pdf = new listadoPDF('P', 'mm', 'A4');
    $pdf->SetTopMargin(10);
    $pdf->SetRightMargin(5);
    $pdf->SetLeftMargin(5);
    $pdf->SetAuthor("Informatica ALBATRONIC, SL");
    $pdf->SetTitle('DATA DICTIONARY');
    $pdf->AliasNbPages();
    $pdf->SetFillColor(210);
    $pdf->SetAutoPageBreak(1, 15);

    // Portada
    $pintarEstado = 'portada';
    $sinPie = 1;
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Ln(120);
    $pdf->Cell(0, 10, "DATA DICTIONARY", 0, 1, "C");
    $pdf->Ln(20);
    $pdf->Cell(0, 10, DB_BASE, 0, 1, "C");
    $pdf->SetFont('Arial', '', 8);


    $indice = array();
    $dependenciasTo = array();
    $dependenciasFrom = array();
    $pintarEstado = 'tables';
    $fin = 0;

    foreach ($tables as $table) {

        $tableName = $table['TABLE_NAME'];
        $td = new tabledescriptor(DB_BASE, $tableName);
        $columns = $td->getColumns();
        $pdf->AddPage();
        $sinPie = 0;
        $indice[] = array('pag' => $pdf->PageNo(), 'table' => $tableName);

        $to = $td->getParentEntities();
        $from = $td->getChildEntities();
        if ($to)
            $dependenciasTo[$tableName] = $to;
        if ($from)
            $dependenciasFrom[$tableName] = $from;

        foreach ($columns as $column) {
            $pdf->Cell(30, 4, $column['Field']);
            $pdf->Cell(12, 4, $column['Type']);
            $pdf->Cell(7, 4, $column['Null']);
            $pdf->Cell(7, 4, $column['Key']);
            $pdf->Cell(10, 4, $column['Length'], 0, 0, "R");
            $pdf->Cell(15, 4, $column['Values']);
            $pdf->Cell(15, 4, $column['Default']);
            $pdf->Cell(25, 4, $column['Extra']);
            $pdf->Cell(28, 4, $column['ReferencedSchema']);
            $pdf->Cell(28, 4, $column['ReferencedEntity']);
            $pdf->Cell(28, 4, $column['ReferencedColumn']);
            $pdf->Ln();
        }
    }

    // PINTAR DEPENDENCIAS TO
    $pintarEstado = 'dependenciesTo';
    $pdf->AddPage();
    foreach ($dependenciasTo as $key => $value) {
        $pdf->Cell(60, 4, $key);
        $pdf->Ln();
        foreach ($value as $entity) {
            $pdf->Cell(60, 4, '');
            $pdf->Cell(0, 4, $entity);
            $pdf->Ln();
        }
        $pdf->Ln();
    }

    // PINTAR DEPENDENCIAS FROM
    $pintarEstado = 'dependenciesFrom'; //print_r($dependenciasFrom);
    $pdf->AddPage();
    foreach ($dependenciasFrom as $key => $value) {
        $pdf->Cell(40, 4, $key);
        $pdf->Ln();
        foreach ($value as $entity) {
            $pdf->Cell(40, 4, '');
            $pdf->Cell(30, 4, $entity['OrignColumn']);
            $pdf->Cell(40, 4, $entity['Schema']);
            $pdf->Cell(30, 4, $entity['Table']);
            $pdf->Cell(30, 4, $entity['Entity']);
            $pdf->Cell(30, 4, $entity['Column']);
            $pdf->Ln();
        }
        $pdf->Ln();
    }

    // PAGINA DE INDICE
    $pintarEstado = 'index';
    $pdf->AddPage();
    foreach ($indice as $key => $value) {
        $pdf->Cell(70, 4, $value['table']);
        $pdf->Cell(10, 4, $value['pag'], 0, 0, "R");
        $pdf->Ln();
    }

    $file = "dd_" . DB_BASE . ".pdf";
    $pdf->Output($file, 'F');
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Data Dictionary Documentor</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>

    <body>
        <form action="ddd.php" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr><td colspan="2" align="center">DATA DICTIONARY DOCUMENTATOR</td></tr>
                <tr><td>Server</td><td><input name="dbhost" type="text" value="localhost"></td></tr>
                <tr><td>User</td><td><input name="dbuser" type="text" value="root"></td></tr>
                <tr><td>Passw</td><td><input name="dbpassword" type="text" value=""></td></tr>
                <tr><td>Data Base</td><td><input name="dbase" type="text" value=""></td></tr>
                <tr><td>Table (optional)</td><td><input name="table" type="text" value=""></td></tr>
                <tr>
                    <td colspan="2" align="center">
                        <input name="accion" value="BUILD" type="submit">&nbsp;
                        <input name="accion" value="CANCEL" type="submit">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>