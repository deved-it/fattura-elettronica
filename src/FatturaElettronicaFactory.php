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
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\Allegato;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;
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
    /** @var string */
    protected $soggettoEmittente;
    /** @var DatiAnagrafici */
    protected $terzoIntermediario;


    /**
     * FatturaElettronicaFactory constructor.
     * @param DatiAnagrafici $datiAnagraficiCedente
     * @param Sede $sedeCedente
     * @param string $telefonoCedente
     * @param string $emailCedente
     * @param DatiAnagrafici|null $terzoIntermediario
     * @param string $soggettoEmittente
     */
    public function __construct(
        DatiAnagrafici $datiAnagraficiCedente,
        Sede $sedeCedente,
        $telefonoCedente,
        $emailCedente,
        DatiAnagrafici $terzoIntermediario = null,
        $soggettoEmittente = 'TZ'
    ) {
        $this->setCedentePrestatore($datiAnagraficiCedente, $sedeCedente);
        $this->setInformazioniContatto($telefonoCedente, $emailCedente);
        if ($terzoIntermediario) {
            $this->setIntermediario($terzoIntermediario, $soggettoEmittente);
        }
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
            $this->idTrasmittente = new IdTrasmittente($datiAnagrafici->idPaese, $datiAnagrafici->codiceFiscale);
        }
    }

    /**
     * @param CedentePrestatore\IscrizioneRea $iscrizioneRea
     */
    public function setIscrizioneRea(CedentePrestatore\IscrizioneRea $iscrizioneRea)
    {
        $this->cedentePrestatore->setIscrizioneRea($iscrizioneRea);
    }

    /**
     * @param DatiTrasmissione\IdTrasmittente $idTrasmittente
     */
    public function setIdTrasmittente(IdTrasmittente $idTrasmittente)
    {
        $this->idTrasmittente = $idTrasmittente;
    }
    
    /**
     * @param DatiAnagrafici $terzoIntermediario
     * @param string $soggettoEmittente
     */
    public function setIntermediario(DatiAnagrafici $terzoIntermediario, $soggettoEmittente = 'TZ')
    {
        $this->terzoIntermediario = $terzoIntermediario;
        $this->soggettoEmittente = $soggettoEmittente;
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

    /**
     * @param DatiAnagrafici $datiAnagrafici
     * @param Sede $sede
     * @param string $codiceDestinatario
     * @param string $pec
     * @param bool $pa
     */
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
     * @param DatiRiepilogo|null $datiRiepilogo
     * @param Allegato|null $allegato
     * @return FatturaElettronica
     * @throws \Exception
     */
    public function create(
        DatiGenerali $datiGenerali,
        DatiPagamento $datiPagamento = null,
        DettaglioLinee $linee,
        $progessivoInvio = false,
        DatiRiepilogo $datiRiepilogo = null,
        Allegato $allegato = null
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
            $this->cessionarioCommittente,
            $this->terzoIntermediario,
            $this->soggettoEmittente
        );
        $datiBeniServizi = new FatturaElettronicaBody\DatiBeniServizi($linee, $datiRiepilogo);
        $fatturaElettronicaBody = new FatturaElettronicaBody(
            $datiGenerali,
            $datiBeniServizi,
            $datiPagamento,
            $allegato
        );
        return new FatturaElettronica($fatturaElettronicaHeader, $fatturaElettronicaBody, $this->xmlFactory);
    }
}
