<?php
/**
 * This file is part of deved/fattura-elettronica
 *
 * Copyright (c) Salvatore Guarino <sg@deved.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Deved\FatturaElettronica\FatturaElettronica;

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CessionarioCommittente;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;
use Deved\FatturaElettronica\XmlSerializableInterface;

class FatturaElettronicaHeader implements XmlSerializableInterface
{
    /** @var DatiTrasmissione */
    public $datiTrasmissione;
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
    ) {
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
        return $writer;
    }
}
