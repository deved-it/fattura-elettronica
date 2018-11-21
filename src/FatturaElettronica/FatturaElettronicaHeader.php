<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:48
 */

namespace Deved\FatturaElettronica\FatturaElettronica;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CessionarioCommittente;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;
use Deved\FatturaElettronica\XmlSerializableInterface;

class FatturaElettronicaHeader implements XmlSerializableInterface
{
    /** @var DatiTrasmissione */
    protected $datiTrasmissione;
    /** @var CedentePrestatore */
    protected $cedentePrestatore;
    /** @var CessionarioCommittente */
    protected $cessionarioCommittente;

    /**
     * FatturaElettronicaHeader constructor.
     * @param DatiTrasmissione $datiTrasmissione
     * @param CedentePrestatore $cedentePrestatore
     * @param CessionarioCommittente $cessionarioCommittente
     */
    public function __construct(
        DatiTrasmissione $datiTrasmissione,
        CedentePrestatore $cedentePrestatore,
        CessionarioCommittente $cessionarioCommittente
    )
    {
        $this->datiTrasmissione = $datiTrasmissione;
        $this->cedentePrestatore = $cedentePrestatore;
        $this->cessionarioCommittente = $cessionarioCommittente;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('FatturaElettronicaHeader');
            $this->datiTrasmissione->toXmlBlock($writer);
            $this->cedentePrestatore->toXmlBlock($writer);
            $this->cessionarioCommittente->toXmlBlock($writer);
        $writer->endElement();
    }
}
