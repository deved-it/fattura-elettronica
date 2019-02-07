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

class DatiRitenuta implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var DatiRitenuta  */
    protected $datiRitenuta;
    /** @var string */
    protected $tipo;
    /** @var float */
    protected $importo;
    /** @var float */
    protected $aliquota;
    /** @var string */
    protected $causale;

    /**
     * DatiRitenuta constructor.
     * @param string $tipo
     * @param float $importo
     * @param float $aliquota
     * @param string $causale
     */
    public function __construct($tipo, $importo, $aliquota, $causale)
    {
        $this->tipo = $tipo;
        $this->importo = $importo;
        $this->aliquota = $aliquota;
        $this->causale = $causale;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiRitenuta');
                $writer->writeElement('TipoRitenuta', $this->tipo);
                $writer->writeElement('ImportoRitenuta', fe_number_format($this->importo,2));
                $writer->writeElement('AliquotaRitenuta', fe_number_format($this->aliquota,2));
                $writer->writeElement('CausalePagamento', $this->causale);
        $writer->endElement();

        return $writer;
    }
}
