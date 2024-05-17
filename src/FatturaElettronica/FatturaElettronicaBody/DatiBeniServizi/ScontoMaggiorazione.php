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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class ScontoMaggiorazione implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    const SCONTO = 'SC';
    const MAGGIORAZIONE = 'MG';


    /** @var string */
    public $tipo;
    /** @var float */
    public $percentuale;
    /** @var float */
    public $importo;

    /**
     * ScontoMaggiorazione constructor.
     * @param $tipo
     * @param $percentuale
     * @param $importo
     */
    public function __construct($tipo, $percentuale, $importo)
    {
        $this->tipo = $tipo;
        $this->percentuale = $percentuale;
        $this->importo = $importo;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('ScontoMaggiorazione');
        $writer->writeElement('Tipo', $this->tipo);
        if ($this->percentuale) {
            $writer->writeElement('Percentuale', fe_number_format($this->percentuale, 8));
        }
        if ($this->importo) {
            $writer->writeElement('Importo', fe_number_format($this->importo, 2));
        }
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }

    /**
     * @param float $totale
     * @return float
     */
    public function applicaScontoMaggiorazione($totale, $quantita, $decimaliLinea)
    {
        if ($this->importo && $decimaliLinea) {
            $importo = fe_number_format($this->importo, $decimaliLinea);
        } else {
            $importo = $this->importo;
        }
        if ($this->tipo ===  ScontoMaggiorazione::SCONTO) {
            $totale -= $this->importo ? ($importo * $quantita) : ($totale * abs($this->percentuale/100));
        }
        else if ($this->tipo ===  ScontoMaggiorazione::MAGGIORAZIONE) {
            $totale += $this->importo ? ($importo * $quantita) : ($totale * abs($this->percentuale/100));
        }
        return $totale;
    }

}
