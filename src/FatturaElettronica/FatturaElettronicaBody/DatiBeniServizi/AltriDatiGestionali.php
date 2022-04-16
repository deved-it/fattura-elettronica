<?php
/**
 * Copyright (c) Gaetano D'Orsi (noirepa)
 * 
 * Definizione del campo AltriDatiGestionali
 * 
 */
namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class AltriDatiGestionali implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** @var string */
    protected $tipoDato;
    /** @var string */
    protected $riferimentoTesto;
    /** @var float */
    protected $riferimentoNumero;
    /** @var  string*/
    protected $riferimentoData;

    /**
     * AltriDatiGestionali constructor.
     * @param string $tipoDato
     * @param string $riferimentoTesto
     * @param float $riferimentoNumero
     * @param string $riferimentoData
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
        $writeADG = $writer;
        /** @var AltriDatiGestionali $block */
            $writeADG->startElement('AltriDatiGestionali');
            $writeADG->writeElement('TipoDato', $this->tipoDato);
            if ($this->riferimentoTesto) {
                $writeADG->writeElement('RiferimentoTesto', $this->riferimentoTesto);
            }
            if ($this->riferimentoNumero) {
                $writeADG->writeElement('RiferimentoNumero', $this->riferimentoNumero);
            }
            if ($this->riferimentoData) {
                $writeADG->writeElement('RiferimentoData', $this->riferimentoData);
            }
            $this->writeXmlFields($writer);
            $writeADG->endElement();

        return $writeADG;
    }
    
}