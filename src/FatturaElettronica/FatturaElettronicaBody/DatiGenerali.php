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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiBollo;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiContratto;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiConvenzione;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiDdt;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiDocumentoCorrelato;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiRitenuta;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiCassaPrevidenziale;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiSal;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\ScontoMaggiorazione;
use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiGenerali implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    /** Lunghezza massima di un elemento Causale (String200LatinType) */
    const LUNGHEZZA_MASSIMA_CAUSALE = 200;

    /** @var string */
    protected $tipoDocumento;
    /** @var string */
    protected $data;
    /** @var string */
    protected $numero;
    /** @var ScontoMaggiorazione */
    protected $scontoMaggiorazione;
    /** @var float */
    protected $importoTotaleDocumento;
    /** @var string */
    protected $divisa;
    /** @var string */
    protected $causale;
    /** @var DatiDdt */
    protected $datiDdt;
    /** @var DatiContratto */
    protected $datiContratto;
    /** @var DatiRitenuta */
    protected $datiRitenuta;
    /** @var DatiBollo */
    protected $datiBollo;
    /** @var DatiCassaPrevidenziale */
    protected $datiCassaPrevidenziale;
    /** @var DatiSal */
    protected $datiSal;
    /** @var DatiConvenzione */
    protected $datiConvenzione;
    /** @var DatiDocumentoCorrelato */
    protected $datiDocumentoCorrelati;


    /**
     * DatiGenerali constructor.
     * @param string $tipoDocumento
     * @param string $data
     * @param string $numero
     * @param float $importoTotaleDocumento
     * @param string $divisa
     */
    public function __construct(
        $tipoDocumento,
        $data,
        $numero,
        $importoTotaleDocumento,
        $divisa = 'EUR'
    )
    {
        $this->tipoDocumento = $tipoDocumento;
        $this->data = $data;
        $this->numero = $numero;
        $this->importoTotaleDocumento = $importoTotaleDocumento;
        $this->divisa = $divisa;
    }

    public function setDatiDdt(DatiDdt $datiDdt)
    {
        $this->datiDdt = $datiDdt;
    }

    public function setDatiConvenzione(DatiConvenzione $datiConvenzione)
    {
        $this->datiConvenzione = $datiConvenzione;
    }

    public function setDatiContratto(DatiContratto $datiContratto)
    {
        $this->datiContratto = $datiContratto;
    }

    public function setDatiDocumentoCorrelato(DatiDocumentoCorrelato $datiDocumentoCorrelati)
    {
        $this->datiDocumentoCorrelati = $datiDocumentoCorrelati;
    }

    public function setDatiRitenuta(DatiRitenuta $datiRitenuta)
    {
        $this->datiRitenuta = $datiRitenuta;
    }

    public function setScontoMaggiorazione(ScontoMaggiorazione $scontoMaggiorazione)
    {
        $this->scontoMaggiorazione = $scontoMaggiorazione;
    }

    public function setDatiBollo(DatiBollo $datiBollo)
    {
        $this->datiBollo = $datiBollo;
    }

    public function setDatiCassaPrevidenziale(DatiCassaPrevidenziale $datiCassaPrevidenziale)
    {
        $this->datiCassaPrevidenziale = $datiCassaPrevidenziale;
    }

    public function setDatiSal(DatiSal $datiSal)
    {
        $this->datiSal = $datiSal;
    }

    /**
     * La Causale può superare i 200 caratteri: in fase di generazione dell'xml
     * viene suddivisa in più elementi Causale (maxOccurs="unbounded")
     * @param string $causale
     */
    public function setCausale(string $causale)
    {
        $this->causale = $causale;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiGenerali');
        $writer->startElement('DatiGeneraliDocumento');
        $writer->writeElement('TipoDocumento', $this->tipoDocumento);
        $writer->writeElement('Divisa', $this->divisa);
        $writer->writeElement('Data', $this->data);
        $writer->writeElement('Numero', $this->numero);
        if ($this->datiRitenuta) {
            $this->datiRitenuta->toXmlBlock($writer);
        }
        if ($this->datiBollo) {
            $this->datiBollo->toXmlBlock($writer);
        }
        if ($this->datiCassaPrevidenziale) {
            $this->datiCassaPrevidenziale->toXmlBlock($writer);
        }
        if ($this->scontoMaggiorazione) {
            $this->scontoMaggiorazione->toXmlBlock($writer);
        }
        $writer->writeElement('ImportoTotaleDocumento', fe_number_format($this->importoTotaleDocumento, 2));
        // la Causale impostata come campo magico ($datiGenerali->Causale) viene
        // scritta qui, suddivisa come quella di setCausale()
        foreach ([$this->causale, $this->Causale] as $causale) {
            if ($causale) {
                foreach (self::dividiCausale($causale) as $parte) {
                    $writer->writeElement('Causale', $parte);
                }
            }
        }
        $this->hideXmlField('Causale');
        $this->writeXmlFields($writer);
        $writer->endElement();

        if ($this->datiContratto) {
            $this->datiContratto->toXmlBlock($writer);
        }
        if ($this->datiConvenzione) {
            $this->datiConvenzione->toXmlBlock($writer);
        }
        if ($this->datiDocumentoCorrelati) {
            $this->datiDocumentoCorrelati->toXmlBlock($writer);
        }
        if ($this->datiSal) {
            $this->datiSal->toXmlBlock($writer);
        }
        if ($this->datiDdt) {
            $this->datiDdt->toXmlBlock($writer);
        }
        $writer->endElement();
        return $writer;
    }

    /**
     * Suddivide la causale in parti da LUNGHEZZA_MASSIMA_CAUSALE caratteri
     * (caratteri, non byte: il pattern dell'XSD conta i caratteri)
     * @param string $causale
     * @return string[]
     */
    protected static function dividiCausale($causale)
    {
        $causale = (string) $causale;
        $pattern = '/.{1,' . self::LUNGHEZZA_MASSIMA_CAUSALE . '}/su';
        if (preg_match_all($pattern, $causale, $parti) === false) {
            // stringa non UTF-8 valida: divisione per byte
            return str_split($causale, self::LUNGHEZZA_MASSIMA_CAUSALE);
        }
        return $parti[0];
    }
}
