<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:50
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione\IdTrasmittente;

class DatiTrasmissione
{
    /** @var IdTrasmittente  */
    protected $idTrasmittente;

    /**
     * DatiTrasmissione constructor.
     * @param IdTrasmittente $idTrasmittente
     */
    public function __construct(
        IdTrasmittente $idTrasmittente
    )
    {
        $this->idTrasmittente = $idTrasmittente;
    }
}
