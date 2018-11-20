<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 17:55
 */

namespace Deved\FatturaElettronica\FatturaElettronica;


use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiPagamento;

class FatturaElettronicaBody
{
    /** @var DatiGenerali  */
    protected $datGenerali;
    /** @var DatiBeniServizi  */
    protected $datiBeniServizi;
    /** @var DatiPagamento  */
    protected $datiPagamento;

    /**
     * FatturaElettronicaBody constructor.
     * @param DatiGenerali $datiGenerali
     * @param DatiBeniServizi $datiBeniServizi
     * @param DatiPagamento $datiPagamento
     */
    public function __construct(
        DatiGenerali $datiGenerali,
        DatiBeniServizi $datiBeniServizi,
        DatiPagamento $datiPagamento
    )
    {
        $this->datGenerali = $datiGenerali;
        $this->datiBeniServizi = $datiBeniServizi;
        $this->datiPagamento = $datiPagamento;
    }
}
