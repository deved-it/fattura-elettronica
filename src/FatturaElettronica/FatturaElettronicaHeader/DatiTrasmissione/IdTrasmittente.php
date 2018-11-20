<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 18:33
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;


class IdTrasmittente
{
    /** @var string */
    protected $idPaese;
    /** @var int */
    protected $idCodice;

    /**
     * IdTrasmittente constructor.
     * @param string $idPaese
     * @param integer $idCodice
     */
    public function __construct($idPaese, $idCodice)
    {
        $this->idPaese = $idPaese;
        $this->idCodice = $idCodice;
    }
}
