<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:57
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;

class DatiBeniServizi
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
}
