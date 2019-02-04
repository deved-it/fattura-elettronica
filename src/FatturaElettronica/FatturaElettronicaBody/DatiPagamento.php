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
use Deved\FatturaElettronica\XmlRepeatedBlock;

class DatiPagamento extends XmlRepeatedBlock
{
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
        parent::__construct();
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var DatiPagamento $block */
        foreach ($this->blocks as $block) {
            $writer->startElement('DatiPagamento');
            $writer->writeElement('CondizioniPagamento', $block->condizioniPagamento);
            $writer->startElement('DettaglioPagamento');
            $writer->writeElement('ModalitaPagamento', $block->modalitaPagamento);
            if ($block->dataScadenzaPagamento) {
                $writer->writeElement('DataScadenzaPagamento', $block->dataScadenzaPagamento);
            }
            $writer->writeElement('ImportoPagamento', fe_number_format($block->importoPagamento, 2));
            if ($block->istitutoFinanziario) {
                $writer->writeElement('IstitutoFinanziario', $block->istitutoFinanziario);
            }
            if ($block->iban) {
                $writer->writeElement('IBAN', $block->iban);
            }
            $block->writeXmlFields($writer);
            $writer->endElement();
            $writer->endElement();
        }
        return $writer;
    }
}
