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

class DatiAnagraficiVettore implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var string */
    public $idPaese;
    /** @var string */
    public $idCodice;
    /** @var string */
    public $codiceFiscale;
    /** @var string */
    public $denominazione;
    /** @var string */
    public $numeroLicenzaGuida;

    /**
     * DatiAnagraficiVettore constructor.
     * @param string $idPaese
     * @param string $idCodice
     * @param string $denominazione
     * @param null|string $codiceFiscale
     * @param null|string $numeroLicenzaGuida
     */
    public function __construct(
        $idPaese,
        $idCodice,
        $denominazione,
        $codiceFiscale = null,
        $numeroLicenzaGuida = null
    )
    {
        $this->idPaese = $idPaese;
        $this->idCodice = $idCodice;
        $this->codiceFiscale = $codiceFiscale;
        $this->denominazione = $denominazione;
        $this->numeroLicenzaGuida = $numeroLicenzaGuida;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiAnagraficiVettore');
            if ($this->idCodice && $this->idPaese) {
                $writer->startElement('IdFiscaleIVA');
                    $writer->writeElement('IdPaese', $this->idPaese);
                    $writer->writeElement('IdCodice', $this->idCodice);
                $writer->endElement();
            }
            if ($this->codiceFiscale) {
                $writer->writeElement('CodiceFiscale', $this->codiceFiscale);
            }
            $writer->startElement('Anagrafica');
                $writer->writeElement('Denominazione', $this->denominazione);
            $writer->endElement();
            if ($this->numeroLicenzaGuida) {
                $writer->writeElement('RegimeFiscale', $this->numeroLicenzaGuida);
            }
            $this->writeXmlFields($writer);
        $writer->endElement();

        return $writer;
    }
}