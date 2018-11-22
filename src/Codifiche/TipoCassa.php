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

namespace Deved\FatturaElettronica\Codifiche;


use Deved\FatturaElettronica\Traits\CodificaTrait;

abstract class TipoCassa
{
    use CodificaTrait;

    const Avvocati = 'TC01';
    const DottoriCommercialisti = 'TC02';
    const Geometri = 'TC03';
    const Architetti = 'TC04';
    const Notai = 'TC05';
    const Ragionieri = 'TC06';
    const ENASARCO = 'TC07';
    const ENPACL = 'TC08';
    const ENPAM = 'TC09';
    const ENPAF = 'TC10';
    const ENPAV = 'TC11';
    const ENPAIA = 'TC12';
    const ImpreseSpedizione = 'TC13';
    const AgenzieMarittime = 'TC13';
    const INPGI = 'TC14';
    const ONAOSI = 'TC15';
    const CASAGIT = 'TC16';
    const EPPI = 'TC17';
    const EPAP = 'TC18';
    const ENPAB = 'TC19';
    const ENPAPI = 'TC20';
    const ENPAP = 'TC21';
    const INPS = 'TC22';


    protected static $tipoCassa = array(
        'TC01' => 'Cassa nazionale previdenza e assistenza avvocati e procuratori legali',
        'TC02' => 'Cassa previdenza dottori commercialisti',
        'TC03' => 'Cassa previdenza e assistenza geometri',
        'TC04' => 'Cassa nazionale previdenza e assistenza ingegneri e architetti liberi professionisti',
        'TC05' => 'Cassa nazionale del notariato',
        'TC06' => 'Cassa nazionale previdenza e assistenza ragionieri e periti commerciali',
        'TC07' => 'Ente nazionale assistenza agenti e rappresentanti di commercio (ENASARCO)',
        'TC08' => 'Ente nazionale previdenza e assistenza consulenti del lavoro (ENPACL)',
        'TC09' => 'Ente nazionale previdenza e assistenza medici (ENPAM)',
        'TC10' => 'Ente nazionale previdenza e assistenza farmacisti (ENPAF)',
        'TC11' => 'Ente nazionale previdenza e assistenza veterinari (ENPAV)',
        'TC12' => 'Ente nazionale previdenza e assistenza impiegati dell\'agricoltura (ENPAIA)',
        'TC13' => 'Fondo previdenza impiegati imprese di spedizione e agenzie marittime',
        'TC14' => 'Istituto nazionale previdenza giornalisti italiani (INPGI)',
        'TC15' => 'Opera nazionale assistenza orfani sanitari italiani (ONAOSI)',
        'TC16' => 'Cassa autonoma assistenza integrativa giornalisti italiani (CASAGIT)',
        'TC17' => 'Ente previdenza periti industriali e periti industriali laureati (EPPI)',
        'TC18' => 'Ente previdenza e assistenza pluricategoriale (EPAP)',
        'TC19' => 'Ente nazionale previdenza e assistenza biologi (ENPAB)',
        'TC20' => 'Ente nazionale previdenza e assistenza professione infermieristica (ENPAPI)',
        'TC21' => 'Ente nazionale previdenza e assistenza psicologi (ENPAP)',
        'TC22' => 'INPS'
    );
}
