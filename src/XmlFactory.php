<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 21/11/2018
 * Time: 11:41
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
        $this->writer->startDocument('1.0','UTF-8');
        $this->writer->setIndent(4);
        $this->processXmlBlock($document);
        return $this->writer->outputMemory(true);
    }
}
