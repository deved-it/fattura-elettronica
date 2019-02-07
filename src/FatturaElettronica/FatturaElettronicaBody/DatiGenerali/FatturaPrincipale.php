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

class FatturaPrincipale implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var string */
    public $numeroFatturaPrincipale;
    /** @var string */
    public $dataFatturaPrincipale;

    /**
     * FatturaPrincipale constructor.
     * @param string $numeroFatturaPrincipale
     * @param string $dataFatturaPrincipale
     */
    public function __construct($numeroFatturaPrincipale, $dataFatturaPrincipale)
    {
        $this->numeroFatturaPrincipale = $numeroFatturaPrincipale;
        $this->dataFatturaPrincipale = $dataFatturaPrincipale;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiAnagraficiVettore');
            $writer->writeElement('NumeroFatturaPrincipale', $this->numeroFatturaPrincipale);
            $writer->writeElement('DataFatturaPrincipale', $this->dataFatturaPrincipale);
        $writer->endElement();

        return $writer;
    }
}