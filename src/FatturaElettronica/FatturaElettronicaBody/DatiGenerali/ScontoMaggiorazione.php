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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class ScontoMaggiorazione implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    const SCONTO = 'SC';
    const MAGGIORAZIONE = 'MG';

    /** @var DatiBollo */
    protected $scontoMaggiorazione;
    /** @var string */
    protected $tipo;
    /** @var float */
    protected $percentuale;
    /** @var float */
    protected $importo;

    /**
     * DatiBollo constructor.
     * @param $bolloVirtuale
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
            $writer->writeElement('Percentuale', fe_number_format($this->percentuale, 2), '.', '');
        }
        if ($this->importo) {
            $writer->writeElement('Importo', fe_number_format($this->importo, 2), '.', '');
        }
        $writer->endElement();
        return $writer;
    }

}
