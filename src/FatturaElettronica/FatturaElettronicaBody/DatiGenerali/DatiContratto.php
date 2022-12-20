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

class DatiContratto implements XmlSerializableInterface, \Countable, \Iterator
{
    const FE_CODE = '2.1.2';
    use MagicFieldsTrait;
    protected $datiContratto = [];
    protected $currentIndex = 0;
    protected $riferimentoNumeroLinee = [];
    protected $idDocumento;

    /**
     * DatiContratto constructor.
     * @param string $idDocumento
     * @param int[] $riferimentoNumeroLinee
     */
    public function __construct($idDocumento, $riferimentoNumeroLinee = [])
    {
        $this->idDocumento = $idDocumento;
        $this->riferimentoNumeroLinee = $riferimentoNumeroLinee;
        $this->datiContratto[] = $this;
    }

    public function addDatiContratto(DatiContratto $datiContratto)
    {
        $this->datiContratto[] = $datiContratto;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current():mixed
    {
        return $this->datiContratto[$this->currentIndex];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next():void
    {
        $this->currentIndex++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key():mixed
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
    public function valid():bool
    {
        return isset($this->datiContratto[$this->currentIndex]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind():void
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
    public function count():int
    {
        return count($this->datiContratto);
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var DatiContratto $block */
        foreach ($this as $block) {
            $writer->startElement('DatiContratto');
                if (count($block->riferimentoNumeroLinee) > 0) {
                    /** @var int $linea */
                    foreach ($block->riferimentoNumeroLinee as $linea) {
                        $writer->writeElement('RiferimentoNumeroLinea', $linea);
                    }
                }
                $writer->writeElement('IdDocumento', $block->idDocumento);
                $block->writeXmlFields($writer);
            $writer->endElement();
        }
        return $writer;
    }
}
