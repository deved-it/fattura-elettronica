<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:52
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use Deved\FatturaElettronica\XmlSerializableInterface;

class CedentePrestatore implements XmlSerializableInterface
{
    /** @var DatiAnagrafici */
    protected $datiAnagrafici;
    /** @var Sede */
    protected $sede;

    /**
     * CedentePrestatore constructor.
     * @param DatiAnagrafici $datiAnagrafici
     * @param Sede $sede
     */
    public function __construct
    (
        DatiAnagrafici $datiAnagrafici,
        Sede $sede
    )
    {
        $this->datiAnagrafici = $datiAnagrafici;
        $this->sede = $sede;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('CedentePrestatore');
            $this->datiAnagrafici->toXmlBlock($writer);
            $this->sede->toXmlBlock($writer);
        $writer->endElement();
    }
}
