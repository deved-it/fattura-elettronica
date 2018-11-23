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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiPagamento;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CessionarioCommittente;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione\IdTrasmittente;

class FatturaElettronicaFactory
{
    /** @var IdTrasmittente */
    protected $idTrasmittente;
    /** @var CedentePrestatore */
    protected $cedentePrestatore;
    /** @var CessionarioCommittente */
    protected $cessionarioCommittente;
    /** @var string */
    protected $codiceDestinatario = "0000000";
    /** @var string */
    protected $pec;
    /** @var bool */
    protected $pa;
    /** @var string */
    protected $telefono;
    /** @var string */
    protected $email;
    /** @var string | integer */
    protected $progressivoInvio = 0;
    /** @var XmlFactory */
    protected $xmlFactory;


    /**
     * FatturaElettronicaFactory constructor.
     * @param DatiAnagrafici $datiAnagraficiCedente
     * @param Sede $sedeCedente
     * @param string $telefonoCedente
     * @param string $emailCedente
     */
    public function __construct(
        DatiAnagrafici $datiAnagraficiCedente,
        Sede $sedeCedente,
        $telefonoCedente,
        $emailCedente
    ) {
        $this->setCedentePrestatore($datiAnagraficiCedente, $sedeCedente);
        $this->setInformazioniContatto($telefonoCedente, $emailCedente);
        $this->xmlFactory = new XmlFactory();
    }

    /**
     * @param DatiAnagrafici $datiAnagrafici
     * @param Sede $sede
     * @param bool $idTrasmittente
     */
    public function setCedentePrestatore(DatiAnagrafici $datiAnagrafici, Sede $sede, $idTrasmittente = true)
    {
        $this->cedentePrestatore = new CedentePrestatore($datiAnagrafici, $sede);
        if ($idTrasmittente) {
            $this->idTrasmittente = new IdTrasmittente($datiAnagrafici->idPaese, $datiAnagrafici->idCodice);
        }
    }

    /**
     * @param string $telefono
     * @param string $email
     */
    public function setInformazioniContatto($telefono, $email)
    {
        $this->telefono = $telefono;
        $this->email = $email;
    }

    public function setCessionarioCommittente(
        DatiAnagrafici $datiAnagrafici,
        Sede $sede,
        $codiceDestinatario = null,
        $pec = null,
        $pa = false
    ) {
        $this->cessionarioCommittente = new CessionarioCommittente($datiAnagrafici, $sede);
        if ($codiceDestinatario) {
            $this->codiceDestinatario = $codiceDestinatario;
        }
        if ($pec) {
            $this->pec = $pec;
        }
        $this->pa = $pa;
    }

    /**
     * @param DatiGenerali $datiGenerali
     * @param DatiPagamento $datiPagamento
     * @param DettaglioLinee $linee
     * @param bool $progessivoInvio
     * @param FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo|null $datiRiepilogo
     * @return FatturaElettronica
     * @throws \Exception
     */
    public function create(
        DatiGenerali $datiGenerali,
        DatiPagamento $datiPagamento,
        DettaglioLinee $linee,
        $progessivoInvio = false,
        FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo $datiRiepilogo = null
    ) {
        if (!$this->cessionarioCommittente) {
            throw new \Exception('Dati cessionario non presenti!');
        }
        if ($progessivoInvio) {
            $this->progressivoInvio = $progessivoInvio;
        } else {
            $this->progressivoInvio++;
        }
        $datiTrasmissione = new FatturaElettronicaHeader\DatiTrasmissione(
            $this->idTrasmittente,
            $this->progressivoInvio,
            $this->codiceDestinatario,
            $this->pa,
            $this->telefono,
            $this->email,
            $this->pec
        );
        $fatturaElettronicaHeader = new FatturaElettronicaHeader(
            $datiTrasmissione,
            $this->cedentePrestatore,
            $this->cessionarioCommittente
        );
        $datiBeniServizi = new FatturaElettronicaBody\DatiBeniServizi($linee, $datiRiepilogo);
        $fatturaElettronicaBody = new FatturaElettronicaBody(
            $datiGenerali,
            $datiBeniServizi,
            $datiPagamento
        );
        return new FatturaElettronica($fatturaElettronicaHeader, $fatturaElettronicaBody, $this->xmlFactory);
    }
}
