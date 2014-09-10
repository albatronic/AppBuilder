<?php

/**
 * GENERAR EL CUADERNO 19 EN FORMATO XML SEGUN SEPA
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @version 1.0 20-02-2014
 */
class SepaXml19
{
    static $xmlStr = "";

    public static function makeDocument($ficheroXml, array $info)
    {
        $xml = self::getDocument($info);
        $fp = @fopen($ficheroXml, "w");
        if ($fp) {
            fwrite($fp, $xml);
            fclose($fp);
        }
    }

    public static function getDocument(array $info)
    {
        self::put("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>");
        self::put("<Document xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns=\"urn:iso:std:iso:20022:tech:xsd:pain.008.001.02\">");
        self::put("<CstmrDrctDbtInitn>", 1);
        self::getHeader($info['header']);
        self::getRecibos($info);
        self::put("</CstmrDrctDbtInitn>", 1);
        self::put("</Document>");

        return self::$xmlStr;
    }

    /**
     * Genera la cabecera
     * @param array $header La información de la cabecera
     */
    public static function getHeader(array $header)
    {
        self::put("<GrpHdr>", 2);
        self::put("<MsgId>{$header['id']}</MsgId>", 3);
        self::put("<CreDtTm>{$header['fecha']}</CreDtTm>", 3);
        self::put("<NbOfTxs>{$header['nRecibos']}</NbOfTxs>", 3);
        self::put("<CtrlSum>{$header['total']}</CtrlSum>", 3);
        self::put("<InitgPty>", 3);
        self::put("<Nm>{$header['razonSocial']}</Nm>", 4);
        self::put("<Id>", 4);
        self::put("<OrgId>", 5);
        self::put("<Othr>", 6);
        self::put("<Id>{$header['cif']}</Id>", 7);
        self::put("</Othr>", 6);
        self::put("</OrgId>", 5);
        self::put("</Id>", 4);
        self::put("</InitgPty>", 3);
        self::put("</GrpHdr>", 2);
    }

    public static function getRecibos(array $info)
    {
        $header = $info['header'];

        self::put("<PmtInf>", 2);
        self::put("<PmtInfId>S1914/11/20140215/1</PmtInfId>", 3);
        self::put("<PmtMtd>DD</PmtMtd>", 3);
        //self::put("<NbOfTxs>{$header['nRecibos']}</NbOfTxs>", 3);
        //self::put("<CtrlSum>{$header['total']}</CtrlSum>", 3);
        self::put("<PmtTpInf><SvcLvl><Cd>SEPA</Cd></SvcLvl><LclInstrm><Cd>CORE</Cd></LclInstrm><SeqTp>RCUR</SeqTp></PmtTpInf>", 3);
        self::put("<ReqdColltnDt>{$header['fechaCargo']}</ReqdColltnDt>", 3);

        self::put("<Cdtr>", 3);
        self::put("<Nm>{$header['razonSocial']}</Nm>", 4);
        self::put("<PstlAdr>", 4);
        self::put("<Ctry>ES</Ctry>", 5);
        self::put("<AdrLine>{$header['direccion1']}</AdrLine>", 5);
        self::put("<AdrLine>{$header['direccion2']}</AdrLine>", 5);
        self::put("</PstlAdr>", 4);
        self::put("</Cdtr>", 3);

        self::put("<CdtrAcct>", 3);
        self::put("<Id><IBAN>{$header['iban']}</IBAN></Id>", 4);
        self::put("<Ccy>EUR</Ccy>", 4);
        self::put("</CdtrAcct>", 3);

        self::put("<CdtrAgt>", 3);
        self::put("<FinInstnId><BIC>{$header['bic']}</BIC></FinInstnId>", 4);
        self::put("</CdtrAgt>", 3);

        self::put("<ChrgBr>SLEV</ChrgBr>", 3);

        self::put("<CdtrSchmeId>", 3);
        self::put("<Id>", 4);
        self::put("<PrvtId>", 5);
        self::put("<Othr>", 6);
        self::put("<Id>{$header['cif']}</Id>", 7);
        self::put("<SchmeNm>", 7);
        self::put("<Prtry>SEPA</Prtry>", 8);
        self::put("</SchmeNm>", 7);
        self::put("</Othr>", 6);
        self::put("</PrvtId>", 5);
        self::put("</Id>", 4);
        self::put("</CdtrSchmeId>", 3);

        foreach ($info['recibos'] as $recibo) {
            self::getRecibo($recibo);
        }

        self::put("</PmtInf>", 2);
    }

    public static function getRecibo(array $recibo)
    {
        self::put("<DrctDbtTxInf>",3);
        self::put("<PmtId>",4);
        self::put("<EndToEndId>{$recibo['numeroFactura']}</EndToEndId>",5);
        self::put("</PmtId>",4);
        self::put("<InstdAmt Ccy=\"EUR\">{$recibo['importe']}</InstdAmt>",4);

        self::put("<DrctDbtTx>",4);
        self::put("<MndtRltdInf>",5);
        self::put("<MndtId>{$recibo['idMandato']}</MndtId>",6);
        self::put("<DtOfSgntr>{$recibo['fechaMandato']}</DtOfSgntr>",6);
        self::put("<AmdmntInd>false</AmdmntInd>",6);
        self::put("</MndtRltdInf>",5);
        self::put("</DrctDbtTx>",4);

        self::put("<DbtrAgt>",4);
        self::put("<FinInstnId>",5);
        self::put("<BIC>{$recibo['bic']}</BIC>",6);
        self::put("</FinInstnId>",5);
        self::put("</DbtrAgt>",4);

        self::put("<Dbtr>",4);
        self::put("<Nm>{$recibo['razonSocial']}</Nm>",4);
        self::put("<PstlAdr>",4);
        self::put("<Ctry>{$recibo['pais']}</Ctry>",5);
        self::put("<AdrLine>{$recibo['direccion1']}</AdrLine>",5);
        self::put("<AdrLine>{$recibo['direccion2']}</AdrLine>",5);
        self::put("</PstlAdr>",4);
        self::put("</Dbtr>",4);

        self::put("<DbtrAcct>",4);
        self::put("<Id>",5);
        self::put("<IBAN>{$recibo['iban']}</IBAN>",6);
        self::put("</Id>",5);
        self::put("</DbtrAcct>",4);

        self::put("<Purp>",4);
        self::put("<Cd>TRAD</Cd>",5);
        self::put("</Purp>",4);

        self::put("<RmtInf>",4);
        self::put("<Ustrd>{$recibo['texto']}</Ustrd>",4);
        self::put("</RmtInf>",4);

        self::put("</DrctDbtTxInf>",3);
    }

    public static function put($texto, $jerarquia = 0)
    {
        $linea = str_repeat(" ", $jerarquia * 2) . $texto . "\n";
        self::$xmlStr .= $linea;
    }

}
