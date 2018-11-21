<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:45
 */

namespace Deved\FatturaElettronica;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;

class FatturaElettronica implements XmlSerializableInterface
{
    /** @var FatturaElettronicaHeader */
    protected $fatturaElettronicaHeader;
    /** @var FatturaElettronicaBody */
    protected $fatturaElettronicaBody;

    public function __construct(
        FatturaElettronicaHeader $fatturaElettronicaHeader,
        FatturaElettronicaBody $fatturaElettronicaBody
    )
    {
        $this->fatturaElettronicaHeader = $fatturaElettronicaHeader;
        $this->fatturaElettronicaBody = $fatturaElettronicaBody;
    }

    /**
     * @return string
     */
    public function toXmlBlock()
    {
        // TODO: Implement toXmlBlock() method.
    }
}
