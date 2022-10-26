<?php

namespace Deved\FatturaElettronica\Enum;

/*
  N1 - escluse ex art. 15

  N2.1 non soggette ad IVA ai sensi degli artt. da 7 a 7-septies del DPR 633/72

  N2.2 non soggette - altri casi

  N3.1 non imponibili - esportazioni

  N3.2 non imponibili - cessioni intracomunitarie

  N3.3 non imponibili - cessioni verso San Marino

  N3.4 non imponibili - operazioni assimilate alle cessioni all'esportazione

  N3.5 non imponibili - a seguito di dichiarazioni d'intento

  N3.6 non imponibili - altre operazioni che non concorrono alla formazione del plafond

  N4 - esenti

  N5 - regime del margine / IVA non esposta in fattura

  N6.1 inversione contabile - cessione di rottami e altri materiali di recupero

  N6.2 inversione contabile - cessione di oro e argento puro

  N6.3 inversione contabile - subappalto nel settore edile

  N6.4 inversione contabile - cessione di fabbricati

  N6.5 inversione contabile - cessione di telefoni cellulari

  N6.6 inversione contabile - cessione di prodotti elettronici

  N6.7 inversione contabile - prestazioni comparto edile e settori connessi

  N6.8 inversione contabile - operazioni settore energetico

  N6.9 inversione contabile - altri casi
 */

/**
 * Description of NaturaIvaType
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com>
 */
class NaturaIvaType {

    const ESCLUSA_ART_15 = "N1";
    const NON_SOGGETTA = "N2";
    const NON_SOGGETTA_DPR633 = "N2.1";
    const NON_SOGGETTA_ALTRI_CASI = "N2.2";
    const NON_IMPONIBILI = "N3";
    const NON_IMPONIBILI_ESPORTAZIONI = "N3.1";
    const NON_IMPONIBILI_CESSIONI_INTRACOMUNITARIA = "N3.2";
    const NON_IMPONIBILI_CESSIONI_SAN_MARINO = "N3.3";
    const NON_IMPONIBILI_OPERAZIONI_ASSIMILATE_CESSIONI_ESPORTAZIONE = "N3.4";
    const NON_IMPONIBILI_DICHIARAZIONE_INTENTO = "N3.5";
    const NON_IMPONIBILI_ALTRE_OPERAZIONI = "N3.6";
    const ESENTI = "N4";
    const REGIME_MARGINE = "N5";
    const REVERSE_CHARGE = "N6";
    const REVERSE_CHARGE_CESSIONE_ROTTAMI = "N6.1";
    const REVERSE_CHARGE_CESSIONE_ORO_ARGENTO = "N6.2";
    const REVERSE_CHARGE_SUBAPPALTO_SETTORE_EDILE = "N6.3";
    const REVERSE_CHARGE_CESSIONE_FABBRICATI = "N6.4";
    const REVERSE_CHARGE_CESSIONE_TELEFONI_CELLULARI = "N6.5";
    const REVERSE_CHARGE_CESSIONE_PRODOTTI_ELETTRONICI = "N6.6";
    const REVERSE_CHARGE_PRESTAZIONI_COMPARTO_EDILE = "N6.7";
    const REVERSE_CHARGE_OPERAZIONI_SETTORE_ENERGETICO = "N6.8";
    const REVERSE_CHARGE_ALTRI_CASI = "N6.9";
    const IVA_ASSOLTA_ESTERO = "N7";

}
