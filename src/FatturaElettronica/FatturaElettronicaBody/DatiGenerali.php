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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiContratto;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiConvenzione;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiDdt;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiRitenuta;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiCassaPrevidenziale;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiSal;
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
    /** @var DatiDdt */
    protected $datiDdt;
    /** @var DatiContratto */
    protected $datiContratto;
    /** @var DatiRitenuta */
    protected $datiRitenuta;
    /** @var DatiCassaPrevidenziale */
    protected $datiCassaPrevidenziale;
    /** @var DatiSal */
    protected $datiSal;
  /** @var DatiConvenzione */
  protected $datiConvenzione;


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

    public function setDatiRitenuta(DatiRitenuta $datiRitenuta)
    {
        $this->datiRitenuta = $datiRitenuta;
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
                if ($this->datiCassaPrevidenziale) {
                    $this->datiCassaPrevidenziale->toXmlBlock($writer);
                }
                $writer->writeElement('ImportoTotaleDocumento',fe_number_format($this->importoTotaleDocumento, 2));
                $this->writeXmlFields($writer);
            $writer->endElement();
            if ($this->datiConvenzione) {
              $this->datiConvenzione->toXmlBlock($writer);
            }
            if ($this->datiContratto) {
                $this->datiContratto->toXmlBlock($writer);
            }
            if ($this->datiSal) {
                $this->datiSal->toXmlBlock($writer);
            }
            if ($this->datiDdt) {
                $this->datiDdt->toXmlBlock($writer);
            }
        $writer->endElement();
        //todo: implementare DatiOrdineAcquisto, DatiContratto etc. (facoltativi)
        return $writer;
    }
}
