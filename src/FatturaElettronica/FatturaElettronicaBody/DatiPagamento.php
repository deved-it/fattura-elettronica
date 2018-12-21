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

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiPagamento implements XmlSerializableInterface
{
    use MagicFieldsTrait;

    public $modalitaPagamento;
    public $dataScadenzaPagamento;
    public $importoPagamento;
    public $iban;
    public $istitutoFinanziario;
    public $condizioniPagamento;

    /**
     * DatiPagamento constructor.
     * @param string $modalitaPagamento
     * @param string $dataScadenzaPagamento
     * @param float $importoPagamento
     * @param string | null $iban
     * @param string | null $istitutoFinanziario
     * @param string $condizioniPagamento
     */
    public function __construct(
        $modalitaPagamento,
        $dataScadenzaPagamento,
        $importoPagamento,
        $iban = null,
        $istitutoFinanziario = null,
        $condizioniPagamento = 'TP02'
    ) {
        $this->modalitaPagamento = $modalitaPagamento;
        $this->dataScadenzaPagamento = $dataScadenzaPagamento;
        $this->importoPagamento = $importoPagamento;
        $this->iban = $iban;
        $this->istitutoFinanziario = $istitutoFinanziario;
        $this->condizioniPagamento = $condizioniPagamento;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiPagamento');
        $writer->writeElement('CondizioniPagamento', $this->condizioniPagamento);
        $writer->startElement('DettaglioPagamento');
        $writer->writeElement('ModalitaPagamento', $this->modalitaPagamento);
        $writer->writeElement('DataScadenzaPagamento', $this->dataScadenzaPagamento);
        $writer->writeElement('ImportoPagamento', fe_number_format($this->importoPagamento, 2));
        if ($this->istitutoFinanziario) {
            $writer->writeElement('IstitutoFinanziario', $this->istitutoFinanziario);
        }
        if ($this->iban) {
            $writer->writeElement('IBAN', $this->iban);
        }
        $this->writeXmlFields($writer);
        $writer->endElement();
        $writer->endElement();

        return $writer;
    }
}
