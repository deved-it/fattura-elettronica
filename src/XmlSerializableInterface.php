<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 21/11/2018
 * Time: 11:34
 */

namespace Deved\FatturaElettronica;


interface XmlSerializableInterface
{
    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer);
}
