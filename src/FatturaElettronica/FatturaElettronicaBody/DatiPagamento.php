<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 18:09
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;

use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiPagamento implements XmlSerializableInterface
{
    protected $modalitaPagamento;
    protected $dataScadenzaPagamento;
    protected $importoPagamento;
    protected $iban;
    protected $istitutoFinanziario;
    protected $condizioniPagamento;

    /**
     * DatiPagamento constructor.
     * @param string $modalitaPagamento
     * @param string $dataScadenzaPagamento
     * @param float $importoPagamento
     * @param string | null $iban
     * @param string | null $istitutoFinanziario
     * @param string $condizioniPagamento
     */
    public function __construct
    (
        $modalitaPagamento,
        $dataScadenzaPagamento,
        $importoPagamento,
        $iban = null,
        $istitutoFinanziario = null,
        $condizioniPagamento = 'TP02'
    )
    {
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
                $writer->writeElement('ImportoPagamento', number_format($this->importoPagamento, 2));
                if ($this->istitutoFinanziario)
                    $writer->writeElement('IstitutoFinanziario', $this->istitutoFinanziario);
                if ($this->iban)
                    $writer->writeElement('IBAN', $this->iban);
            $writer->endElement();
        $writer->endElement();
    }
}
