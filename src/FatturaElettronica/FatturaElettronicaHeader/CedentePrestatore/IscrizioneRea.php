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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore;

use Deved\FatturaElettronica\XmlSerializableInterface;

class IscrizioneRea implements XmlSerializableInterface
{
    /** @var string  */
    protected $ufficio;
    /** @var string  */
    protected $numeroRea;
    /** @var float|null  */
    protected $capitaleSociale;
    /** @var string|null  */
    protected $socioUnico;
    /** @var string  */
    protected $statoLiquidazione;

    /**
     * IscrizioneRea constructor.
     * @param string $ufficio
     * @param string $numeroRea
     * @param null|float $capitaleSociale
     * @param null|string $socioUnico
     * @param string $statoLiquidazione
     */
    public function __construct($ufficio, $numeroRea, $capitaleSociale = null, $socioUnico = null, $statoLiquidazione = 'LN')
    {
        $this->ufficio = $ufficio;
        $this->numeroRea = $numeroRea;
        $this->capitaleSociale = $capitaleSociale;
        $this->socioUnico = $socioUnico;
        $this->statoLiquidazione = $statoLiquidazione;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('IscrizioneREA');
        $writer->writeElement('Ufficio', $this->ufficio);
        $writer->writeElement('NumeroREA', $this->numeroRea);
        if ($this->capitaleSociale) {
            $writer->writeElement('CapitaleSociale', fe_number_format($this->capitaleSociale));
        }
        if ($this->socioUnico) {
            $writer->writeElement('SocioUnico', $this->socioUnico);
        }
        $writer->writeElement('StatoLiquidazione', $this->statoLiquidazione);
        $writer->endElement();

        return $writer;
    }
}
