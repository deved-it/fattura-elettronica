<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:57
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiBeniServizi implements XmlSerializableInterface
{

    /** @var DettaglioLinee */
    protected $dettaglioLinee;

    /**
     * DatiBeniServizi constructor.
     * @param DettaglioLinee $dettaglioLinee
     */
    public function __construct(DettaglioLinee $dettaglioLinee)
    {
        $this->dettaglioLinee = $dettaglioLinee;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiBeniServizi');
            $this->dettaglioLinee->toXmlBlock($writer);
        $writer->endElement();
    }
}
