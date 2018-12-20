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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\Linea;
use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiBeniServizi implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var DettaglioLinee */
    protected $dettaglioLinee;
    /** @var DatiRiepilogo */
    protected $datiRiepilogo;

    /**
     * DatiBeniServizi constructor.
     * @param DettaglioLinee $dettaglioLinee
     * @param DatiRiepilogo|null $datiRiepilogo
     */
    public function __construct(DettaglioLinee $dettaglioLinee, DatiRiepilogo $datiRiepilogo = null)
    {
        $this->dettaglioLinee = $dettaglioLinee;
        if ($datiRiepilogo) {
            $this->datiRiepilogo = $datiRiepilogo;
            return;
        }
        $this->datiRiepilogo = $this->calcolaDatiRiepilogo();
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiBeniServizi');
            $this->dettaglioLinee->toXmlBlock($writer);
            $this->datiRiepilogo->toXmlBlock($writer);
            $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }

    /**
     * @return DatiRiepilogo
     */
    protected function calcolaDatiRiepilogo()
    {
        $imponibile = 0;
        $aliquota = 22;
        /** @var Linea $linea */
        foreach ($this->dettaglioLinee as $linea) {
            $imponibile += $linea->prezzoTotale(false);
            $aliquota = $linea->getAliquotaIva();
        }
        return new DatiRiepilogo($imponibile, $aliquota);
    }
}
