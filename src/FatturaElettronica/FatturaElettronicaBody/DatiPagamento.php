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
    public $dataRiferimentoTerminiPagamento;
    public $dataScadenzaPagamento;
    public $importoPagamento;
    public $iban;
    public $istitutoFinanziario;
    public $condizioniPagamento;
    public $beneficiario;

    /** @var DatiPagamento[] */
    protected $dettagliPagamento = [];

    /**
     * DatiPagamento constructor.
     * @param string $modalitaPagamento
     * @param string $dataScadenzaPagamento
     * @param float $importoPagamento
     * @param string | null $iban
     * @param string | null $istitutoFinanziario
     * @param string $condizioniPagamento
     * @param string | null $dataRiferimentoTerminiPagamento
     * @param string | null $beneficiario
     */
    public function __construct(
        $modalitaPagamento,
        $dataScadenzaPagamento,
        $importoPagamento,
        $iban = null,
        $istitutoFinanziario = null,
        $condizioniPagamento = 'TP02',
        $dataRiferimentoTerminiPagamento = null,
        $beneficiario = null
    ) {
        $this->modalitaPagamento = $modalitaPagamento;
        $this->dataRiferimentoTerminiPagamento = $dataRiferimentoTerminiPagamento;
        $this->dataScadenzaPagamento = $dataScadenzaPagamento;
        $this->importoPagamento = $importoPagamento;
        $this->iban = $iban;
        $this->istitutoFinanziario = $istitutoFinanziario;
        $this->condizioniPagamento = $condizioniPagamento;
        $this->beneficiario = $beneficiario;
        parent::__construct();
    }

    /**
     * Aggiunge un DettaglioPagamento allo stesso blocco DatiPagamento
     * (es. le rate di un pagamento TP01). Del dettaglio aggiunto viene usato
     * solo il contenuto di DettaglioPagamento: CondizioniPagamento resta
     * quella di questo blocco.
     * Per un nuovo blocco DatiPagamento usare invece addBlock().
     * @param DatiPagamento $dettaglio
     */
    public function addDettaglioPagamento(DatiPagamento $dettaglio)
    {
        $this->dettagliPagamento[] = $dettaglio;
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
            $block->dettaglioPagamentoToXmlBlock($writer);
            foreach ($block->dettagliPagamento as $dettaglio) {
                $dettaglio->dettaglioPagamentoToXmlBlock($writer);
            }
            $writer->endElement();
        }
        return $writer;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    protected function dettaglioPagamentoToXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DettaglioPagamento');
        // Beneficiario è il primo elemento di DettaglioPagamento: anche se
        // impostato come campo magico ($datiPagamento->Beneficiario) va scritto qui
        $beneficiario = $this->beneficiario ?: $this->Beneficiario;
        if ($beneficiario) {
            $writer->writeElement('Beneficiario', $beneficiario);
        }
        $this->hideXmlField('Beneficiario');
        $writer->writeElement('ModalitaPagamento', $this->modalitaPagamento);
        if ($this->dataRiferimentoTerminiPagamento) {
            $writer->writeElement('DataRiferimentoTerminiPagamento', $this->dataRiferimentoTerminiPagamento);
        }
        if ($this->dataScadenzaPagamento) {
            $writer->writeElement('DataScadenzaPagamento', $this->dataScadenzaPagamento);
        }
        $writer->writeElement('ImportoPagamento', fe_number_format($this->importoPagamento, 2));
        if ($this->istitutoFinanziario) {
            $writer->writeElement('IstitutoFinanziario', $this->istitutoFinanziario);
        }
        if ($this->iban) {
            $writer->writeElement('IBAN', $this->iban);
        }
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }
}
