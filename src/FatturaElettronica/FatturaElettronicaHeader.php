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
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;
use Deved\FatturaElettronica\XmlSerializableInterface;
use phpDocumentor\Reflection\Types\Nullable;

class FatturaElettronicaHeader implements XmlSerializableInterface
{
    /** @var DatiTrasmissione */
    public $datiTrasmissione;
    /** @var CedentePrestatore */
    protected $cedentePrestatore;
    /** @var CessionarioCommittente */
    protected $cessionarioCommittente;
    /** @var DatiAnagrafici|null */
    protected $terzoIntermediario;
    /** @var string */
    protected $soggettoEmittente;

    /**
     * FatturaElettronicaHeader constructor.
     * @param DatiTrasmissione $datiTrasmissione
     * @param CedentePrestatore $cedentePrestatore
     * @param CessionarioCommittente $cessionarioCommittente
     * @param DatiAnagrafici|null $terzoIntermediario
     * @param string $soggettoEmittente
     */
    public function __construct(
        DatiTrasmissione $datiTrasmissione,
        CedentePrestatore $cedentePrestatore,
        CessionarioCommittente $cessionarioCommittente,
        DatiAnagrafici $terzoIntermediario = null,
        $soggettoEmittente = 'TZ'
    ) {
        $this->datiTrasmissione = $datiTrasmissione;
        $this->cedentePrestatore = $cedentePrestatore;
        $this->cessionarioCommittente = $cessionarioCommittente;
        $this->terzoIntermediario = $terzoIntermediario;
        $this->soggettoEmittente = $soggettoEmittente;
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
            if ($this->terzoIntermediario) {
                $writer->startElement('TerzoIntermediarioOSoggettoEmittente');
                    $this->terzoIntermediario->toXmlBlock($writer);
                $writer->endElement();
                $writer->writeElement('SoggettoEmittente', $this->soggettoEmittente);
            }
        $writer->endElement();
        return $writer;
    }
}
