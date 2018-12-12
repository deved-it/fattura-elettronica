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

use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiRiepilogo implements XmlSerializableInterface
{
    /** @var float */
    protected $aliquotaIVA;
    /** @var float */
    protected $imponibileImporto;
    /** @var float */
    protected $imposta;
    /** @var string */
    protected $esigibilitaIVA = "I";

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
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiRiepilogo');
            $writer->writeElement('AliquotaIVA', fe_number_format($this->aliquotaIVA, 2));
            $writer->writeElement('ImponibileImporto', fe_number_format($this->imponibileImporto, 2));
            $writer->writeElement('Imposta', fe_number_format($this->imposta, 2));
            $writer->writeElement('EsigibilitaIVA', $this->esigibilitaIVA);
        $writer->endElement();

        return $writer;
    }
}
