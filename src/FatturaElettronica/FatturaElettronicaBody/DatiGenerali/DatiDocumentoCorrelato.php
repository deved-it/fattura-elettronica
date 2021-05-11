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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiDocumentoCorrelato implements XmlSerializableInterface, \Countable, \Iterator
{
    use MagicFieldsTrait;

    const OrdineAcquisto = 'DatiOrdineAcquisto';
    const Contratto = 'DatiDocumentoCorrelato';
    const Convenzione = 'DatiConvenzione';
    const Ricezione = 'DatiRicezione';
    const FattureCollegate = 'DatiFattureCollegate';

    protected $tipoDocumentoCorrelato;
    protected $datiDocumentiCorrelati = [];
    protected $codiceCommessaConvenzione = '';
    protected $currentIndex = 0;
    protected $riferimentoNumeroLinee = [];
    protected $idDocumento;
    protected $numItem;
    protected $codiceCUP;
    protected $codiceCIG;
    protected $data;

    /**
     * DatiDocumentoCorrelato constructor.
     * @param string $idDocumento
     * @param int[] $riferimentoNumeroLinee
     */
    public function __construct($tipoDocumentoCorrelato, $idDocumento, $data, $riferimentoNumeroLinee = [], $codiceCommessaConvenzione = '', $numItem = '', $codiceCUP = null, $codiceCIG = null)
    {
        $this->tipoDocumentoCorrelato = $tipoDocumentoCorrelato;
        $this->idDocumento = $idDocumento;
        $this->riferimentoNumeroLinee = $riferimentoNumeroLinee;
        $this->data = $data;
        $this->codiceCommessaConvenzione = $codiceCommessaConvenzione;
        $this->numItem = $numItem;
        $this->codiceCUP = $codiceCUP;
        $this->codiceCIG = $codiceCIG;
        $this->datiDocumentiCorrelati[] = $this;
    }

    public function addDatiDocumentoCorrelato(DatiDocumentoCorrelato $datiDocumentiCorrelati)
    {
        $this->datiDocumentiCorrelati[] = $datiDocumentiCorrelati;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->datiDocumentiCorrelati[$this->currentIndex];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->currentIndex++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->currentIndex;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->datiDocumentiCorrelati[$this->currentIndex]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->datiDocumentiCorrelati);
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var DatiDocumentoCorrelato $block */
        foreach ($this as $block) {
            $writer->startElement($block->tipoDocumentoCorrelato);
                if (count($block->riferimentoNumeroLinee) > 0) {
                    /** @var int $linea */
                    foreach ($block->riferimentoNumeroLinee as $linea) {
                        $writer->writeElement('RiferimentoNumeroLinea', $linea);
                    }
                }
                $writer->writeElement('IdDocumento', $block->idDocumento);
                if ($block->data) {
                    $writer->writeElement('Data', $block->data);
                }
                if ($block->numItem) {
                    $writer->writeElement('NumItem', $block->numItem);
                }
                if ($block->codiceCommessaConvenzione) {
                    $writer->writeElement('CodiceCommessaConvenzione', $block->codiceCommessaConvenzione);
                }
                if ($block->codiceCUP) {
                    $writer->writeElement('CodiceCUP', $block->codiceCUP);
                }
                if ($block->codiceCIG) {
                    $writer->writeElement('CodiceCIG', $block->codiceCIG);
                }
            $writer->endElement();
        }
        return $writer;
    }
}
