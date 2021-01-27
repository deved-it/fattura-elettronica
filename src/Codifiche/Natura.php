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

    /** Codice non più valido per le fatture emesse a partire dal primo gennaio 2021 */
    const NonSoggette = 'N2';
    const NonSoggetteArt7 = 'N2.1';
    const NonSoggetteAltro = 'N2.2';

    /** Codice non più valido per le fatture emesse a partire dal primo gennaio 2021 */
    const NonImponibili = 'N3';
    const NonImponibiliEsportazioni = 'N3.1';
    const NonImponibiliCessioniIntracomunitarie = 'N3.2';
    const NonImponibiliCessioniSanMarino = 'N3.3';
    const NonImponibiliOperazioniAssimilate = 'N3.4';
    const NonImponibiliDichiarazioniIntento = 'N3.5';
    const NonImponibiliAltreOperazioni = 'N3.6';

    const Esenti = 'N4';

    const RegimeDelMargine = 'N5';

    /** Codice non più valido per le fatture emesse a partire dal primo gennaio 2021 */
    const InversioneContabile = 'N6';
    const InversioneContabileCessioneRottami = 'N6.1';
    const InversioneContabileCessioneOroArgento = 'N6.2';
    const InversioneContabileSubappaltoEdile = 'N6.3';
    const InversioneContabileCessioneFabbricati = 'N6.4';
    const InversioneContabileCessioneTelefoniCellulari = 'N6.5';
    const InversioneContabileCessioneProdottiElettronici = 'N6.6';
    const InversioneContabilePrestazioniCompartoEdile = 'N6.7';
    const InversioneContabileOperazioniSettoreEnergetico = 'N6.8';
    const InversioneContabileAltriCasi = 'N6.9';

    const IvaAssoltaUe = 'N7';

    protected static $codifiche = array(
        'N1' => 'escluse ex art. 15',
        'N2' => 'non soggette',
        'N2.1' => 'non soggette ad IVA ai sensi degli artt. da 7 a 7-septies del DPR 633/72',
        'N2.2' => 'non soggette - altri casi',
        'N3' => 'non imponibili',
        'N3.1' => 'non imponibili - esportazioni',
        'N3.2' => 'non imponibili - cessioni intracomunitarie',
        'N3.3' => 'non imponibili - cessioni verso San Marino',
        'N3.4' => 'non imponibili - operazioni assimilate alle cessioni all\'esportazione',
        'N3.5' => 'non imponibili - a seguito di dichiarazioni d\'intento',
        'N3.6' => 'non imponibili - altre operazioni che non concorrono alla formazione del plafond',
        'N4' => 'esenti',
        'N5' => 'regime del margine / IVA non esposta in fattura',
        'N6' => 'inversione contabile (per le operazioni in reverse charge ovvero nei casi di autofatturazione per acquisti extra UE di servizi ovvero per importazioni di beni nei soli casi previsti)',
        'N6.1' => 'inversione contabile - cessione di rottami e altri materiali di recupero',
        'N6.2' => 'inversione contabile - cessione di oro e argento puro',
        'N6.3' => 'inversione contabile - subappalto nel settore edile',
        'N6.4' => 'inversione contabile - cessione di fabbricati',
        'N6.5' => 'inversione contabile - cessione di telefoni cellulari',
        'N6.6' => 'inversione contabile - cessione di prodotti elettronici',
        'N6.7' => 'inversione contabile - prestazioni comparto edile e settori connessi',
        'N6.8' => 'inversione contabile - operazioni settore energetico',
        'N6.9' => 'inversione contabile - altri casi',
        'N7' => 'IVA assolta in altro stato UE (vendite a distanza ex art. 40 c. 3 e 4 e art. 
        41 c. 1 lett. b,  DL 331/93; prestazione di servizi di telecomunicazioni, tele-radiodiffusione 
        ed elettronici ex art. 7-sexies lett. f, g, art. 74-sexies DPR 633/72)'
    );
}
