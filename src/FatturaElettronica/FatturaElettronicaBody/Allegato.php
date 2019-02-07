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

use Deved\FatturaElettronica\XmlRepeatedBlock;

class Allegato extends XmlRepeatedBlock
{
    public $nomeAttachment;
    public $algoritmoCompressione;
    public $formatoAttachment;
    public $descrizioneAttachment;
    public $attachment;

    /**
     * Allegati constructor.
     * @param string $nomeAttachment
     * @param string $attachment
     * @param string | null $algoritmoCompressione
     * @param string | null $formatoAttachment
     * @param string | null $descrizioneAttachment
     */
    public function __construct(
        $nomeAttachment,
        $attachment,
        $formatoAttachment = null,
        $algoritmoCompressione = null,
        $descrizioneAttachment = null
    ) {
        $this->nomeAttachment = $nomeAttachment;
        $this->algoritmoCompressione = $algoritmoCompressione;
        $this->formatoAttachment = $formatoAttachment;
        $this->descrizioneAttachment = $descrizioneAttachment;
        $this->attachment = $attachment;
        parent::__construct();
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        /** @var Allegato $block */
        foreach ($this->blocks as $block) {
            $writer->startElement('Allegati');
            $writer->writeElement('NomeAttachment', $block->nomeAttachment);
            if ($block->algoritmoCompressione) {
                $writer->writeElement('AlgoritmoCompressione', $block->algoritmoCompressione);
            }
            if ($block->formatoAttachment) {
                $writer->writeElement('FormatoAttachment', $block->formatoAttachment);
            }
            if ($block->descrizioneAttachment) {
                $writer->writeElement('DescrizioneAttachment', $block->descrizioneAttachment);
            }
            $writer->writeElement('Attachment', base64_encode($block->attachment));
            $block->writeXmlFields($writer);
            $writer->endElement();
        }
        return $writer;
    }
}