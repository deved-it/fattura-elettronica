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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiAnagrafici implements XmlSerializableInterface
{
    use MagicFieldsTrait;
    /** @var string */
    public $codiceFiscale;
    /** @var string */
    public $denominazione;
    /** @var string */
    public $nome;
    /** @var string */
    public $cognome;
    /** @var string */
    public $idPaese;
    /** @var string */
    public $idCodice;
    /** @var string */
    public $regimeFiscale;

    public function __construct(
        $codiceFiscale,
        $denominazione,
        $idPaese = '',
        $idCodice = '',
        $regimeFiscale = '',
        $nome = '',
        $cognome = ''
    ) {
        $this->codiceFiscale = $codiceFiscale;
        $this->denominazione = $denominazione;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->idPaese = $idPaese;
        $this->idCodice = $idCodice;
        $this->regimeFiscale = $regimeFiscale;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiAnagrafici');
        if ($this->idCodice && $this->idPaese) {
            $writer->startElement('IdFiscaleIVA');
                $writer->writeElement('IdPaese', $this->idPaese);
                $writer->writeElement('IdCodice', $this->idCodice);
            $writer->endElement();
        }
            $writer->writeElement('CodiceFiscale', $this->codiceFiscale);
            $writer->startElement('Anagrafica');
                if ($this->denominazione) {
                    $writer->writeElement('Denominazione', $this->denominazione);
                } else {
                    $writer->writeElement('Nome', $this->nome);
                    $writer->writeElement('Cognome', $this->cognome);
                }
            $writer->endElement();
        if ($this->regimeFiscale) {
            $writer->writeElement('RegimeFiscale', $this->regimeFiscale);
        }
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }
}
