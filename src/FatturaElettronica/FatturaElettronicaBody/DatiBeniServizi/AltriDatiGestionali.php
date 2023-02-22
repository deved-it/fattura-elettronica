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

class AltriDatiGestionali implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var string */
    public $tipoDato;
    /** @var string */
    public $riferimentoTesto;
    /** @var string */
    public $riferimentoNumero;
    /** @var string */
    public $riferimentoData;

    /**
     * AltriDatiGestionali constructor.
     *
     * @param $tipoDato
     * @param null $riferimentoTesto
     * @param null $riferimentoNumero
     * @param null $riferimentoData
     */
    public function __construct($tipoDato, $riferimentoTesto = null, $riferimentoNumero = null, $riferimentoData = null)
    {
        $this->tipoDato = $tipoDato;
        $this->riferimentoTesto = $riferimentoTesto;
        $this->riferimentoNumero = $riferimentoNumero;
        $this->riferimentoData = $riferimentoData;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('AltriDatiGestionali');
        $writer->writeElement('TipoDato', $this->tipoDato);
        if ($this->riferimentoTesto) $writer->writeElement('RiferimentoTesto', $this->riferimentoTesto);
        if ($this->riferimentoNumero) $writer->writeElement('RiferimentoNumero', $this->riferimentoNumero);
        if ($this->riferimentoData) $writer->writeElement('RiferimentoData', $this->riferimentoData);
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }

}
