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
use Deved\FatturaElettronica\XmlRepeatedBlock;

class ScontoMaggiorazione extends XmlRepeatedBlock
{
    use MagicFieldsTrait;

    /** @var string */
    protected $tipo;
    /** @var float */
    protected $percentuale;
    /** @var float */
    protected $importo;

    /**
     * ScontoMaggiorazione constructor.
     * @param $tipo
     * @param float|null $importo
     * @param float|null $percentuale
     */
    public function __construct(
        $tipo,
        $importo = null,
        $percentuale = null
    )
    {
        $this->tipo = $tipo;
        $this->importo = $importo;
        $this->percentuale = $percentuale;

        parent::__construct();
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var ScontoMaggiorazione $block */
        foreach ($this as $block) {
            $writer->startElement('ScontoMaggiorazione');
                $writer->writeElement('Tipo', $block->tipo);
                if (!is_null($this->percentuale)) {
                    $writer->writeElement('Percentuale', fe_number_format($block->percentuale, 2));
                }
                if (!is_null($this->importo)) {
                    $writer->writeElement('Importo', fe_number_format($block->importo, 2));
                }
                $block->writeXmlFields($writer);
            $writer->endElement();
        }

        return $writer;
    }
}