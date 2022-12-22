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

use Deved\FatturaElettronica\Enum\NaturaIvaType;
use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class Linea implements XmlSerializableInterface
{
    use MagicFieldsTrait;
    /** @var int */
    protected $numeroLinea;
    /** @var string */
    protected $codiceArticolo;
    /** @var string */
    protected $descrizione;
    /** @var float */
    protected $quantita;
    /** @var string */
    protected $unitaMisura;
    /** @var float */
    protected $prezzoUnitario;
    /** @var float */
    protected $aliquotaIva;
    /** @var string */

    protected $codiceTipo;
    /** @var ScontoMaggiorazione[]|null */
    protected $scontoMaggiorazione = [];
    /** @var int */
    protected $decimaliLinea;
    /** @var string */
    protected $tipoCessionePrestazione;
    /** @var NaturaIvaType|null */
    protected $naturaIva;
    protected $natura;
    /** @var AltriDatiGestionali[]|null */
    protected $altriDatiGestionali = [];

    /**
     * Linea constructor.
     * @param $descrizione
     * @param $prezzoUnitario
     * @param null $codiceArticolo
     * @param float $quantita
     * @param string $unitaMisura
     * @param float $aliquotaIva
     * @param string $codiceTipo
     * @param int $decimaliLinea
     * @param string $natura
     */
    public function __construct(
        $descrizione,
        $prezzoUnitario,
        $codiceArticolo = null,
        $quantita = null,
        $unitaMisura = 'pz',
        $aliquotaIva = 22.00,

        $codiceTipo = 'FORN',
        $decimaliLinea = 2,
        $tipoCessionePrestazione = null,
        $naturaIva = null,
        $natura = null
    ) {
        $this->codiceArticolo = $codiceArticolo;
        $this->descrizione = $descrizione;
        $this->prezzoUnitario = $prezzoUnitario;
        $this->quantita = $quantita;
        $this->unitaMisura = $unitaMisura;
        $this->aliquotaIva = $aliquotaIva;
        $this->codiceTipo = $codiceTipo;
        $this->decimaliLinea = $decimaliLinea;
        $this->tipoCessionePrestazione = $tipoCessionePrestazione;
        $this->naturaIva = $naturaIva;
        $this->natura = $natura;
    }


    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DettaglioLinee');
        $writer->writeElement('NumeroLinea', $this->numeroLinea);
        if ($this->tipoCessionePrestazione) {
            $writer->writeElement('TipoCessionePrestazione', $this->tipoCessionePrestazione);
        }
        if ($this->codiceArticolo) {
            $writer->startElement('CodiceArticolo');

            $writer->writeElement('CodiceTipo', $this->codiceTipo);

            $writer->writeElement('CodiceValore', $this->codiceArticolo);
            $writer->endElement();
        }
        $writer->writeElement('Descrizione', $this->descrizione);
        if ($this->quantita) {
            $writer->writeElement('Quantita', fe_number_format($this->quantita, $this->decimaliQuantita()));
            $writer->writeElement('UnitaMisura', $this->unitaMisura);
        }
        $this->writeXmlField('DataInizioPeriodo', $writer);
        $this->writeXmlField('DataFinePeriodo', $writer);
        $writer->writeElement('PrezzoUnitario', fe_number_format($this->prezzoUnitario, $this->decimaliLinea));
        foreach ($this->scontoMaggiorazione as $item) {
            $writer = $item->toXmlBlock($writer);
        }
        $writer->writeElement('PrezzoTotale', $this->prezzoTotale());
        $writer->writeElement('AliquotaIVA', fe_number_format($this->aliquotaIva, 2));

        if($this->naturaIva !== null) {
            $writer->writeElement('Natura', $this->naturaIva);
        }    

        if ($this->natura) {
            $writer->writeElement('Natura', $this->natura);
        }
        foreach ($this->altriDatiGestionali as $item) {
            $writer = $item->toXmlBlock($writer);
        }
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }

    /**
     * Calcola e restituisce il prezzo totale della linea
     *
     * @param bool $format
     * @return string | float
     */
    public function prezzoTotale($format = true)
    {
        $quantita = $this->quantita ?: 1;
        $totale = $this->prezzoUnitario * $quantita;
        if ($format) {
            $totale = fe_number_format($totale, $this->decimaliLinea);
        }
        foreach ($this->scontoMaggiorazione as $item) {
            $totale = $item->applicaScontoMaggiorazione($totale, $quantita, $format ? $this->decimaliLinea : null);
        }
        return fe_number_format($totale, $this->decimaliLinea);
    }

    /**
     * Restituisce il numero di decimali della quantita
     *
     * @return int
     */
    public function decimaliQuantita()
    {
        return max(min(strlen(substr(strrchr($this->quantita, "."), 1)), 8), 2);
    }

    /**
     * Imposta il numero riga
     *
     * @param integer $n
     */
    public function setNumeroLinea($n)
    {
        $this->numeroLinea = $n;
    }

    /**
     * Restituisce Aliquota IVA
     *
     * @return float
     */
    public function getAliquotaIva()
    {
        return $this->aliquotaIva;
    }

    public function setScontoMaggiorazione(ScontoMaggiorazione $scontoMaggiorazione)
    {
        $this->scontoMaggiorazione[] = $scontoMaggiorazione;
    }

    public function setAltriDatiGestionali(AltriDatiGestionali $altriDatiGestionali)
    {
        $this->altriDatiGestionali[] = $altriDatiGestionali;
    }
}
