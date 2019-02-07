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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\DatiAnagraficiVettore;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\IndirizzoResa;
use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiTrasporto implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var DatiAnagraficiVettore  */
    protected $datiAnagraficiVettore;
    /** @var string */
    protected $mezzoTrasporto;
    /** @var string */
    protected $causaleTrasporto;
    /** @var integer */
    protected $numeroColli;
    /** @var string */
    protected $descrizione;
    /** @var string */
    protected $unitaMisuraPeso;
    /** @var float */
    protected $pesoLordo;
    /** @var float */
    protected $pesoNetto;
    /** @var string */
    protected $dataOraRitiro;
    /** @var string */
    protected $dataInizioTrasporto;
    /** @var string */
    protected $tipoResa;
    /** @var IndirizzoResa */
    protected $indirizzoResa;
    /** @var string */
    protected $dataOraConsegna;

    /**
     * DatiTrasporto constructor.
     * @param DatiAnagraficiVettore|null $datiAnagraficiVettore
     * @param null|string $mezzoTrasporto
     * @param null|string $causaleTrasporto
     * @param null|integer $numeroColli
     * @param null|string $descrizione
     * @param null|string $unitaMisuraPeso
     * @param null|float $pesoLordo
     * @param null|float $pesoNetto
     * @param null|string $dataOraRitiro
     * @param null|string $dataInizioTrasporto
     * @param null|string $tipoResa
     * @param IndirizzoResa|null $indirizzoResa
     * @param null|string $dataOraConsegna
     */
    public function __construct(
        DatiAnagraficiVettore $datiAnagraficiVettore = null,
        $mezzoTrasporto = null,
        $causaleTrasporto = null,
        $numeroColli = null,
        $descrizione = null,
        $unitaMisuraPeso = null,
        $pesoLordo = null,
        $pesoNetto = null,
        $dataOraRitiro = null,
        $dataInizioTrasporto = null,
        $tipoResa = null,
        IndirizzoResa $indirizzoResa = null,
        $dataOraConsegna = null
    )
    {
        $this->datiAnagraficiVettore = $datiAnagraficiVettore;
        $this->mezzoTrasporto = $mezzoTrasporto;
        $this->causaleTrasporto = $causaleTrasporto;
        $this->numeroColli = $numeroColli;
        $this->descrizione = $descrizione;
        $this->unitaMisuraPeso = $unitaMisuraPeso;
        $this->pesoLordo = $pesoLordo;
        $this->pesoNetto = $pesoNetto;
        $this->dataOraRitiro = $dataOraRitiro;
        $this->dataInizioTrasporto = $dataInizioTrasporto;
        $this->tipoResa = $tipoResa;
        $this->indirizzoResa = $indirizzoResa;
        $this->dataOraConsegna = $dataOraConsegna;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiTrasporto');
            if ($this->datiAnagraficiVettore) {
                $this->datiAnagraficiVettore->toXmlBlock($writer);
            }
            if ($this->mezzoTrasporto) {
                $writer->writeElement('MezzoTrasporto', $this->mezzoTrasporto);
            }
            if ($this->causaleTrasporto) {
                $writer->writeElement('CausaleTrasporto', $this->causaleTrasporto);
            }
            if ($this->numeroColli) {
                $writer->writeElement('NumeroColli', $this->numeroColli);
            }
            if ($this->descrizione) {
                $writer->writeElement('Descrizione', $this->descrizione);
            }
            if ($this->unitaMisuraPeso) {
                $writer->writeElement('UnitaMisuraPeso', $this->unitaMisuraPeso);
            }
            if ($this->pesoLordo) {
                $writer->writeElement('PesoLordo', $this->pesoLordo);
            }
            if ($this->pesoNetto) {
                $writer->writeElement('PesoNetto', $this->pesoNetto);
            }
            if ($this->dataOraRitiro) {
                $writer->writeElement('DataOraRitiro', $this->dataOraRitiro);
            }
            if ($this->dataInizioTrasporto) {
                $writer->writeElement('DataInizioTrasporto', $this->dataInizioTrasporto);
            }
            if ($this->tipoResa) {
                $writer->writeElement('TipoResa', $this->tipoResa);
            }
            if ($this->indirizzoResa) {
                $this->indirizzoResa->toXmlBlock($writer);
            }
            if ($this->dataOraConsegna) {
                $writer->writeElement('DataOraConsegna', $this->dataOraConsegna);
            }
            $this->writeXmlFields($writer);
        $writer->endElement();

        return $writer;
    }
}