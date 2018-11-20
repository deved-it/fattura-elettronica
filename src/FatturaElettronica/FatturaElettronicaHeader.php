<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:48
 */

namespace Deved\FatturaElettronica\FatturaElettronica;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CessionarioCommittente;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;

class FatturaElettronicaHeader
{
    /** @var DatiTrasmissione */
    protected $datiTrasmissione;
    /** @var CedentePrestatore */
    protected $cedentePrestatore;
    /** @var CessionarioCommittente */
    protected $cessionarioCommittente;

    /**
     * FatturaElettronicaHeader constructor.
     * @param DatiTrasmissione $datiTrasmissione
     * @param CedentePrestatore $cedentePrestatore
     * @param CessionarioCommittente $cessionarioCommittente
     */
    public function __construct(
        DatiTrasmissione $datiTrasmissione,
        CedentePrestatore $cedentePrestatore,
        CessionarioCommittente $cessionarioCommittente
    )
    {
        $this->datiTrasmissione = $datiTrasmissione;
        $this->cedentePrestatore = $cedentePrestatore;
        $this->cessionarioCommittente = $cessionarioCommittente;
    }
}
