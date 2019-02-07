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
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiFattureCollegate;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiOrdineAcquisto;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiRicezione;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiRitenuta;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiCassaPrevidenziale;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiSal;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\FatturaPrincipale;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\ScontoMaggiorazione;
use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiGenerali implements XmlSerializableInterface
{
    use MagicFieldsTrait;
    /** @var string */
    protected $tipoDocumento;
    /** @var string */
    protected $data;
    /** @var string */
    protected $numero;
    /** @var float */
    protected $importoTotaleDocumento;
    /** @var string */
    protected $divisa;
    /** @var DatiRitenuta */
    protected $datiRitenuta;
    /** @var DatiBollo */
    protected $datiBollo;
    /** @var DatiCassaPrevidenziale */
    protected $datiCassaPrevidenziale;
    /** @var ScontoMaggiorazione */
    protected $scontoMaggiorazione;
    /** @var DatiOrdineAcquisto */
    protected $datiOrdineAcquisto;
    /** @var DatiContratto */
    protected $datiContratto;
    /** @var DatiConvenzione */
    protected $datiConvenzione;
    /** @var DatiRicezione */
    protected $datiRicezione;
    /** @var DatiFattureCollegate */
    protected $datiFattureCollegate;
    /** @var DatiSal */
    protected $datiSal;
    /** @var DatiDdt */
    protected $datiDdt;
    /** @var DatiTrasporto */
    protected $datiTrasporto;
    /** @var FatturaPrincipale */
    protected $fatturaPrincipale;

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
    ) {
        $this->tipoDocumento = $tipoDocumento;
        $this->data = $data;
        $this->numero = $numero;
        $this->importoTotaleDocumento = $importoTotaleDocumento;
        $this->divisa = $divisa;
    }

    public function setDatiRitenuta(DatiRitenuta $datiRitenuta)
    {
        $this->datiRitenuta = $datiRitenuta;
    }

    public function setDatiBollo(DatiBollo $datiBollo)
    {
        $this->datiBollo = $datiBollo;
    }

    public function setDatiCassaPrevidenziale(DatiCassaPrevidenziale $datiCassaPrevidenziale)
    {
        $this->datiCassaPrevidenziale = $datiCassaPrevidenziale;
    }

    public function setScontoMaggiorazione(ScontoMaggiorazione $scontoMaggiorazione)
    {
        $this->scontoMaggiorazione = $scontoMaggiorazione;
    }

    public function setDatiOrdineAcquisto(DatiOrdineAcquisto $datiOrdineAcquisto)
    {
        $this->datiOrdineAcquisto = $datiOrdineAcquisto;
    }

    public function setDatiContratto(DatiContratto $datiContratto)
    {
        $this->datiContratto = $datiContratto;
    }

    public function setDatiConvenzione(DatiConvenzione $datiConvenzione)
    {
        $this->datiConvenzione = $datiConvenzione;
    }

    public function setDatiRicezione(DatiRicezione $datiRicezione)
    {
        $this->datiRicezione = $datiRicezione;
    }

    public function setDatiFattureCollegate(DatiFattureCollegate $datiFattureCollegate)
    {
        $this->datiFattureCollegate = $datiFattureCollegate;
    }

    public function setDatiSal(DatiSal $datiSal)
    {
        $this->datiSal = $datiSal;
    }

    public function setDatiDdt(DatiDdt $datiDdt)
    {
        $this->datiDdt = $datiDdt;
    }

    public function setDatiTrasporto(DatiTrasporto $datiTrasporto)
    {
        $this->datiTrasporto = $datiTrasporto;
    }

    public function setFatturaPrincipale(FatturaPrincipale $fatturaPrincipale)
    {
        $this->fatturaPrincipale = $fatturaPrincipale;
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
                $writer->writeElement('ImportoTotaleDocumento',fe_number_format($this->importoTotaleDocumento, 2));
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
                $this->writeXmlFields($writer);
            $writer->endElement();
            if ($this->datiOrdineAcquisto) {
                $this->datiOrdineAcquisto->toXmlBlock($writer);
            }
            if ($this->datiContratto) {
                $this->datiContratto->toXmlBlock($writer);
            }
            if ($this->datiConvenzione) {
                $this->datiConvenzione->toXmlBlock($writer);
            }
            if ($this->datiRicezione) {
                $this->datiRicezione->toXmlBlock($writer);
            }
            if ($this->datiFattureCollegate) {
                $this->datiFattureCollegate->toXmlBlock($writer);
            }
            if ($this->datiSal) {
                $this->datiSal->toXmlBlock($writer);
            }
            if ($this->datiDdt) {
                $this->datiDdt->toXmlBlock($writer);
            }
            if ($this->datiTrasporto) {
                $this->datiTrasporto->toXmlBlock($writer);
            }
            if ($this->fatturaPrincipale) {
                $this->fatturaPrincipale->toXmlBlock($writer);
            }
        $writer->endElement();

        return $writer;
    }
}
