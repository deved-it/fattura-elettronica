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

class DatiOrdineAcquisto implements XmlSerializableInterface, \Countable, \Iterator
{
    use MagicFieldsTrait;

    protected $datiOrdineAcquisto = [];
    protected $currentIndex = 0;
    protected $riferimentoNumeroLinee = [];
    protected $idDocumento;
    protected $data;
    protected $numItem;
    protected $codiceCommessaConvenzione;
    protected $codiceCup;
    protected $codiceCig;

    /**
     * DatiOrdineAcquisto constructor.
     * @param string $idDocumento
     * @param int[] $riferimentoNumeroLinee
     * @param null $data
     * @param null $numItem
     * @param null $codiceCommessaConvenzione
     * @param null $codiceCup
     * @param null $codiceCig
     */
    public function __construct(
        $idDocumento,
        $riferimentoNumeroLinee = [],
        $data = null,
        $numItem = null,
        $codiceCommessaConvenzione = null,
        $codiceCup = null,
        $codiceCig = null
    )
    {
        $this->idDocumento = $idDocumento;
        $this->riferimentoNumeroLinee = $riferimentoNumeroLinee;
        $this->data = $data;
        $this->numItem = $numItem;
        $this->codiceCommessaConvenzione = $codiceCommessaConvenzione;
        $this->codiceCup = $codiceCup;
        $this->codiceCig = $codiceCig;
        $this->datiOrdineAcquisto[] = $this;
    }

    public function addDatiOrdineAcquisto(DatiOrdineAcquisto $datiOrdineAcquisto)
    {
        $this->datiOrdineAcquisto[] = $datiOrdineAcquisto;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->datiOrdineAcquisto[$this->currentIndex];
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
        return isset($this->datiOrdineAcquisto[$this->currentIndex]);
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
        return count($this->datiOrdineAcquisto);
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var DatiOrdineAcquisto $block */
        foreach ($this as $block) {
            $writer->startElement('DatiOrdineAcquisto');
                if (count($block->riferimentoNumeroLinee) > 0) {
                    /** @var int $linea */
                    foreach ($block->riferimentoNumeroLinee as $linea) {
                        $writer->writeElement('RiferimentoNumeroLinea', $linea);
                    }
                }
                $writer->writeElement('IdDocumento', $block->idDocumento);
                if ($this->data) {
                    $writer->writeElement('Data', $block->data);
                }
                if ($this->numItem) {
                    $writer->writeElement('NumItem', $block->numItem);
                }
                if ($this->codiceCommessaConvenzione) {
                    $writer->writeElement('CodiceCommessaConvenzione', $block->codiceCommessaConvenzione);
                }
                if ($this->codiceCup) {
                    $writer->writeElement('CodiceCUP', $block->codiceCup);
                }
                if ($this->codiceCig) {
                    $writer->writeElement('CodiceCIG', $block->codiceCig);
                }
                $block->writeXmlFields($writer);
            $writer->endElement();
        }
        return $writer;
    }
}
