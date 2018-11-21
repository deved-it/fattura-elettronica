<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 18:33
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;


use Deved\FatturaElettronica\XmlSerializableInterface;

class IdTrasmittente implements XmlSerializableInterface
{
    /** @var string */
    protected $idPaese;
    /** @var int */
    protected $idCodice;

    /**
     * IdTrasmittente constructor.
     * @param string $idPaese
     * @param integer $idCodice
     */
    public function __construct($idPaese, $idCodice)
    {
        $this->idPaese = $idPaese;
        $this->idCodice = $idCodice;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('IdTrasmittente');
            $writer->writeElement('IdPaese', $this->idPaese);
            $writer->writeElement('IdCodice', $this->idCodice);
        $writer->endElement();
        return $writer;
    }
}
