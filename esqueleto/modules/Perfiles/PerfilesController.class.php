<?php

/**
 * CONTROLLER FOR Perfiles
 * @author: Sergio Perez <sergio.perez@albatronic.com>
 * @copyright: INFORMATICA ALBATRONIC SL 
 * @date 07.06.2011 19:41:33

 * Extiende a la clase controller
 */

class PerfilesController extends controller {

    protected $entity = "Perfiles";
    protected $parentEntity = "";

    public function listadoAction() {

        $pdf = new PDF("P", 'mm', "A4");
        $pdf->SetTopMargin(15);
        $pdf->SetLeftMargin(10);
        $pdf->AliasNbPages();
        $pdf->SetFillColor(210);

        $em = new entityManager("empresas");
        $query = "select t1.IDPerfil,t1.Permisos,t4.Perfil,t2.Titulo as Opcion,t3.Titulo as SubOpcion
                from permisos as t1,menu as t2, submenu as t3, perfiles as t4
                where t1.IDOpcion=t2.IDOpcion
                and t1.IDOpcion=t3.IDOpcion
                and t3.Id=t1.IDSubOpcion
                and t1.IDPerfil=t4.IDPerfil
                order by t1.IDPerfil,t1.IDOpcion,t1.IDSubOpcion;";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();

        $perant = "";
        $opcant = "";
        foreach ($rows as $row) {
            if ($perant != $row['IDPerfil']) {
                $pdf->AddPage();
                $pdf->Cell(40, 5, $row['Perfil'], 0, 0, "L", 1);
            } else
                $pdf->Cell(40, 5, "", 0, 0, "L", 0);

            $pdf->SetFillColor(240);

            if ($opcant != $row['Opcion'])
                $pdf->Cell(30, 5, $row['Opcion'], 0, 0, "L", 1);
            else
                $pdf->Cell(30, 5, "", 0, 0, "L", 0);
            $perant = $row['IDPerfil'];
            $opcant = $row['Opcion'];


            $pdf->Cell(40, 5, $row['SubOpcion'], 0, 0, "L", 0);
            $permisos = array(
                'C' => substr($row['Permisos'], 0, 1),
                'I' => substr($row['Permisos'], 1, 1),
                'B' => substr($row['Permisos'], 2, 1),
                'A' => substr($row['Permisos'], 3, 1),
                'L' => substr($row['Permisos'], 4, 1),
                'E' => substr($row['Permisos'], 5, 1)
            );
            $pdf->Cell(13, 5, $permisos['C'], 0, 0, "C", 0);
            $pdf->Cell(13, 5, $permisos['I'], 0, 0, "C", 1);
            $pdf->Cell(13, 5, $permisos['B'], 0, 0, "C", 0);
            $pdf->Cell(13, 5, $permisos['A'], 0, 0, "C", 1);
            $pdf->Cell(13, 5, $permisos['L'], 0, 0, "C", 0);
            $pdf->Cell(13, 5, $permisos['E'], 0, 1, "C", 1);
            $pdf->SetFillColor(210);
        }

        $archivo = "docs/docs" . $_SESSION['emp'] . "/pdfs/" . md5(date('d-m-Y H:i:s')) . ".pdf";
        $pdf->Output($archivo, 'F');

        $this->values['archivo'] = $archivo;
        return array('template' => '_global/listadoPdf.html.twig', 'values' => $this->values,);
    }

}

class PDF extends FPDF {

//Cabecera de pagina
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, "INFORME DE PERMISOS DE ACCESO", 0, 1, "C", 1);
        $this->SetFont('Arial', '', 8);

        //TITULOS DEL CUERPO
        $this->Cell(40, 5, "Perfil", 0, 0, "C");
        $this->Cell(30, 5, "Opcion", 0, 0, "C");
        $this->Cell(40, 5, "SubOpcion", 0, 0, "C");
        $this->Cell(13, 5, "Consultar", 0, 0, "C");
        $this->Cell(13, 5, "Crear", 0, 0, "C");
        $this->Cell(13, 5, "Borrar", 0, 0, "C");
        $this->Cell(13, 5, "Modificar", 0, 0, "C");
        $this->Cell(13, 5, "Imprimir", 0, 0, "C");
        $this->Cell(13, 5, "Excel", 0, 1, "C");
    }

//Pie de pagina
    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->SetXY(10, -10);
        $this->Cell(5, 4, date('d/m/Y H:i:s'));
        $this->Cell(105, 4, "Pag. " . $this->PageNo() . '/{nb}', 0, 0, "R");
        $this->Cell(80, 4, $_SESSION['USER']['user']['Nombre'], 0, 0, "R");
    }

}

?>