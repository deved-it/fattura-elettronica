<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:45
 */

namespace Deved\FatturaElettronica;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;

class FatturaElettronica implements XmlSerializableInterface
{
    /** @var FatturaElettronicaHeader */
    protected $fatturaElettronicaHeader;
    /** @var FatturaElettronicaBody */
    protected $fatturaElettronicaBody;

    public function __construct(
        FatturaElettronicaHeader $fatturaElettronicaHeader,
        FatturaElettronicaBody $fatturaElettronicaBody
    )
    {
        $this->fatturaElettronicaHeader = $fatturaElettronicaHeader;
        $this->fatturaElettronicaBody = $fatturaElettronicaBody;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElementNS('p','FatturaElettronica', null);
        $writer->writeAttribute('versione', 'FPR12');
        $writer->writeAttributeNS('xmlns', 'ds', null, 'http://www.w3.org/2000/09/xmldsig#');
        $writer->writeAttributeNS('xmlns', 'p', null, 'http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2');
        $writer->writeAttributeNS('xmlns', 'xsi', null, 'http://www.w3.org/2001/XMLSchema-instance');
        $this->fatturaElettronicaHeader->toXmlBlock($writer);
        $this->fatturaElettronicaBody->toXmlBlock($writer);
        $writer->endElement();
        return $writer;
    }
}
