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

abstract class ModalitaPagamento
{
    use CodificaTrait;

    const Contanti = 'MP01';
    const Assegno = 'MP02';
    const AssegnoCircolare = 'MP03';
    const ContantiPressoTesoreria = 'MP04';
    const Bonifico = 'MP05';
    const VagliaCambiario = 'MP06';
    const BollettinoBancario = 'MP07';
    const CartaDiPagamento = 'MP08';
    const RID = 'MP09';
    const RIDUtenze = 'MP10';
    const RIDVeloce = 'MP11';
    const RIBA = 'MP12';
    const MAV = 'MP13';
    const QuietanzaErario = 'MP14';
    const GirocontoSpeciale = 'MP15';
    const DomiciliazioneBancaria = 'MP16';
    const DomiciliazionePostale = 'MP17';
    const BollettinoPostale = 'MP18';
    const SEPA = 'MP19';
    const SEPA_CORE = 'MP20';
    const SEPA_B2B = 'MP21';
    const TrattenutaSommeRiscosse = 'MP22';


    protected static $codifiche = array(
        'MP01' => 'contanti',
        'MP02' => 'assegno',
        'MP03' => 'assegno circolare',
        'MP04' => 'contanti presso Tesoreria',
        'MP05' => 'bonifico',
        'MP06' => 'vaglia cambiario',
        'MP07' => 'bollettino bancario',
        'MP08' => 'carta di pagamento',
        'MP09' => 'RID',
        'MP10' => 'RID utenze',
        'MP11' => 'RID veloce',
        'MP12' => 'RIBA',
        'MP13' => 'MAV',
        'MP14' => 'quietanza erario',
        'MP15' => 'giroconto su conti di contabilità speciale',
        'MP16' => 'domiciliazione bancaria',
        'MP17' => 'domiciliazione postale',
        'MP18' => 'bollettino di c/c postale',
        'MP19' => 'SEPA Direct Debit',
        'MP20' => 'SEPA Direct Debit CORE',
        'MP21' => 'SEPA Direct Debit B2B',
        'MP22' => 'Trattenuta su somme già riscosse'
    );

}
