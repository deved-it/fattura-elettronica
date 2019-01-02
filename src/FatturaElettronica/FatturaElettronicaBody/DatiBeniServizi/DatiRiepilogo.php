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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiRiepilogo implements XmlSerializableInterface, \Countable, \Iterator
{
    use MagicFieldsTrait;
    /** @var float */
    protected $aliquotaIVA;
    /** @var float */
    protected $imponibileImporto;
    /** @var float */
    protected $imposta;
    /** @var string */
    protected $esigibilitaIVA = "I";
    /** @var DatiRiepilogo[] */
    protected $datiRiepilogoAggiuntivi = [];
    /** @var int  */
    protected $currentIndex = 0;

    /**
     * DatiRiepilogo constructor.
     * @param $imponibileImporto
     * @param $aliquotaIVA
     * @param string $esigibilitaIVA
     * @param bool $imposta
     */
    public function __construct($imponibileImporto, $aliquotaIVA, $esigibilitaIVA = "I", $imposta = false)
    {
        if ($imposta === false) {
            $this->imposta = ($imponibileImporto / 100) * $aliquotaIVA;
        } else {
            $this->imposta = $imposta;
        }
        $this->imponibileImporto = $imponibileImporto;
        $this->aliquotaIVA = $aliquotaIVA;
        $this->esigibilitaIVA = $esigibilitaIVA;
        $this->datiRiepilogoAggiuntivi[] = $this;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var DatiRiepilogo $block */
        foreach ($this as $block) {
            $natura = $block->natura;
            $writer->startElement('DatiRiepilogo');
            $writer->writeElement('AliquotaIVA', fe_number_format($block->aliquotaIVA, 2));
            $block->writeXmlField('Natura', $writer);
            $writer->writeElement('ImponibileImporto', fe_number_format($block->imponibileImporto, 2));
            $writer->writeElement('Imposta', fe_number_format($block->imposta, 2));
            if (!$natura) {
                $writer->writeElement('EsigibilitaIVA', $block->esigibilitaIVA);
            }
            $block->writeXmlFields($writer);
            $writer->endElement();
        }
        return $writer;
    }

    public function addDatiRiepilogo(DatiRiepilogo $datiRiepilogo)
    {
        $this->datiRiepilogoAggiuntivi[] = $datiRiepilogo;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->datiRiepilogoAggiuntivi[$this->currentIndex];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->currentIndex++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->currentIndex;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->datiRiepilogoAggiuntivi[$this->currentIndex]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->datiRiepilogoAggiuntivi);
    }
}
