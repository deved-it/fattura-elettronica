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

abstract class Natura
{
    use CodificaTrait;

    const EscluseArt15 = 'N1';
    const NonSoggette = 'N2';
    const NonImponibili = 'N3';
    const Esenti = 'N4';
    const RegimeDelMargine = 'N5';
    const InversioneContabile = 'N6';
    const IvaAssoltaUe = 'N7';

    protected static $codifiche = array(
        'N1' => 'escluse ex art. 15',
        'N2' => 'non soggette',
        'N3' => 'non imponibili',
        'N4' => 'esenti',
        'N5' => 'regime del margine / IVA non esposta in fattura',
        'N6' => 'inversione contabile (per le operazioni in reverse charge ovvero nei casi di autofatturazione per 
        acquisti extra UE di servizi ovvero per importazioni di beni nei soli casi previsti)',
        'N7' => 'IVA assolta in altro stato UE (vendite a distanza ex art. 40 c. 3 e 4 e art. 
        41 c. 1 lett. b,  DL 331/93; prestazione di servizi di telecomunicazioni, tele-radiodiffusione 
        ed elettronici ex art. 7-sexies lett. f, g, art. 74-sexies DPR 633/72)'
    );
}
