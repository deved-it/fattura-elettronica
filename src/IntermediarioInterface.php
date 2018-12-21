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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;

interface IntermediarioInterface
{
    /**
     * Restituisce i dati anagrafici dell'intermediario
     *
     * @return DatiAnagrafici
     */
    public function getAnagraficaIntermediario();

    /**
     * Restituisce 'TZ' o 'CC'
     *
     * @return string
     */
    public function getSoggettoEmittente();
}
