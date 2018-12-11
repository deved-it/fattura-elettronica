<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 11/12/2018
 * Time: 17:27
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
