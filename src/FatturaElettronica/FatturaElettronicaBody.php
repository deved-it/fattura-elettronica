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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\Allegato;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiPagamento;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiVeicoli;
use Deved\FatturaElettronica\XmlSerializableInterface;

class FatturaElettronicaBody implements XmlSerializableInterface
{
    const FE_CODE = '2.0';
    /** @var DatiGenerali  */
    public $datiGenerali;
    /** @var DatiBeniServizi  */
    protected $datiBeniServizi;
    /** @var DatiPagamento  */
    protected $datiPagamento;
    /** @var Allegato  */
    protected $allegato;
    /** @var DatiVeicoli  */
    protected $datiVeicoli;

    /**
     * FatturaElettronicaBody constructor.
     * @param DatiGenerali $datiGenerali
     * @param DatiBeniServizi $datiBeniServizi
     * @param DatiPagamento $datiPagamento
     */
    public function __construct(
        DatiGenerali $datiGenerali,
        DatiBeniServizi $datiBeniServizi,
        DatiPagamento $datiPagamento = null,
        Allegato $allegato = null,
        DatiVeicoli $datiVeicoli = null
    ) {
        $this->datiGenerali = $datiGenerali;
        $this->datiBeniServizi = $datiBeniServizi;
        $this->datiPagamento = $datiPagamento;
        $this->allegato = $allegato;
        $this->datiVeicoli = $datiVeicoli;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('FatturaElettronicaBody');
            $this->datiGenerali->toXmlBlock($writer);
            $this->datiBeniServizi->toXmlBlock($writer);
            if ($this->datiVeicoli) {
                $this->datiVeicoli->toXmlBlock($writer);
            }
            if ($this->datiPagamento) {
                $this->datiPagamento->toXmlBlock($writer);
            }
            if ($this->allegato) {
                $this->allegato->toXmlBlock($writer);
            }
        $writer->endElement();
        return $writer;
    }
}
