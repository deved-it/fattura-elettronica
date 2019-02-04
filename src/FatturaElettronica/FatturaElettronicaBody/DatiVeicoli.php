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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiVeicoli implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var string */
    protected $data;
    /** @var string */
    protected $totalePercorso;

    /**
     * DatiVeicoli constructor.
     * @param string $data
     * @param string $totalePercorso
     */
    public function __construct($data, $totalePercorso)
    {
        $this->data = $data;
        $this->totalePercorso = $totalePercorso;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiVeicoli');
        $writer->writeElement('Data', $this->data);
        $writer->writeElement('TotalePercorso', $this->totalePercorso);
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }
}