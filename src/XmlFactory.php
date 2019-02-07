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

namespace Deved\FatturaElettronica;

class XmlFactory
{
    /** @var \XMLWriter */
    protected $writer;

    /**
     * XmlFactory constructor.
     * @param \XMLWriter|null $writer
     */
    public function __construct(\XMLWriter $writer = null)
    {
        $this->writer = $writer ? $writer : new \XMLWriter();
    }

    /**
     * @param XmlSerializableInterface $block
     * @return void
     */
    protected function processXmlBlock(XmlSerializableInterface $block)
    {
        $block->toXmlBlock($this->writer);
    }

    /**
     * @param XmlSerializableInterface $document
     * @return string
     */
    public function toXml(XmlSerializableInterface $document)
    {
        $this->writer->openMemory();
        $this->writer->startDocument('1.0', 'UTF-8');
        $this->writer->setIndent(true);
        $this->writer->setIndentString('  ');
        $this->processXmlBlock($document);
        return $this->writer->outputMemory(true);
    }
}
