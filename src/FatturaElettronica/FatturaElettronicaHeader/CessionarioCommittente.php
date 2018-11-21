<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:55
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use Deved\FatturaElettronica\XmlSerializableInterface;

class CessionarioCommittente implements XmlSerializableInterface
{
    /** @var DatiAnagrafici */
    protected $datiAnagrafici;
    /** @var Sede */
    protected $sede;

    /**
     * CessionarioCommittente constructor.
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
        $writer->startElement('CessionarioCommittente');
            $this->datiAnagrafici->toXmlBlock($writer);
            $this->sede->toXmlBlock($writer);
        $writer->endElement();
    }
}
