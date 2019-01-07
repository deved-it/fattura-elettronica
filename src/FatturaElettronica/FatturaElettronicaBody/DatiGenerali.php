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
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiDdt;
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

    public function setDatiContratto(DatiContratto $datiContratto)
    {
        $this->datiContratto = $datiContratto;
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
                $writer->writeElement(
                    'ImportoTotaleDocumento',
                    fe_number_format($this->importoTotaleDocumento, 2)
                );
                $this->writeXmlFields($writer);
            $writer->endElement();
            if ($this->datiContratto) {
                $this->datiContratto->toXmlBlock($writer);
            }
            if ($this->datiDdt) {
                $this->datiDdt->toXmlBlock($writer);
            }
        $writer->endElement();
        //todo: implementare DatiOrdineAcquisto, DatiContratto etc. (facoltativi)
        return $writer;
    }
}
