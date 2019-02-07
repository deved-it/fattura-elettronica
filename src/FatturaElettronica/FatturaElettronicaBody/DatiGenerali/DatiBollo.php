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

class DatiBollo implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var DatiBollo  */
    protected $datiBollo;
    /** @var float */
    protected $importoBollo;
    /** @var string */
    protected $bolloVirtuale;

    /**
     * DatiBollo constructor.
     * @param float $importoBollo
     * @param string $bolloVirtuale
     */
    public function __construct($importoBollo, $bolloVirtuale = 'SI')
    {
        $this->importoBollo = $importoBollo;
        $this->bolloVirtuale = $bolloVirtuale;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiBollo');
            $writer->writeElement('BolloVirtuale', $this->bolloVirtuale);
            $writer->writeElement('ImportoBollo', fe_number_format($this->importoBollo,2));
        $writer->endElement();

        return $writer;
    }
}
