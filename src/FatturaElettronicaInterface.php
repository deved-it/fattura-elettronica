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


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore\IscrizioneRea;

interface FatturaElettronicaInterface
{
    /**
     * Restituisce il nome della fattura conforme all'SDI
     * @return string
     */
    public function getFileName();

    /**
     * Restituisce l'XML della fattura elettronica
     * @return string
     * @throws \Exception
     */
    public function toXml();

    /**
     * @param IscrizioneRea $iscrizioneRea
     * @return mixed
     */
    public function setIscrizioneRea(IscrizioneRea $iscrizioneRea);
}
