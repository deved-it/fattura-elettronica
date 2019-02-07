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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class IndirizzoResa implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var string */
    protected $nazione;
    /** @var string */
    protected $indirizzo;
    /** @var string */
    protected $cap;
    /** @var string */
    protected $comune;
    /** @var string */
    protected $provincia;

    /**
     * IndirizzoResa constructor.
     * @param string $nazione
     * @param string $indirizzo
     * @param string $cap
     * @param string $comune
     * @param string $provincia
     */
    public function __construct(
        $nazione,
        $indirizzo,
        $cap,
        $comune,
        $provincia = ''
    ) {
        $this->nazione = $nazione;
        $this->indirizzo = $indirizzo;
        $this->cap = $cap;
        $this->comune = $comune;
        $this->provincia = $provincia;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('IndirizzoResa');
            $writer->writeElement('Indirizzo', $this->indirizzo);
            $writer->writeElement('CAP', $this->cap);
            $writer->writeElement('Comune', $this->comune);
            if ($this->provincia) {
                $writer->writeElement('Provincia', $this->provincia);
            }
            $writer->writeElement('Nazione', $this->nazione);
            $this->writeXmlFields($writer);
        $writer->endElement();

        return $writer;
    }
}