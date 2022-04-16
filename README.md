[![Latest Version on Packagist](https://img.shields.io/packagist/v/deved/fattura-elettronica.svg?style=flat-square)](https://packagist.org/packages/deved/fattura-elettronica)
[![Build Status](https://travis-ci.org/deved-it/fattura-elettronica.svg?branch=master)](https://travis-ci.org/deved-it/fattura-elettronica)
[![Total Downloads](https://img.shields.io/packagist/dt/deved/fattura-elettronica.svg?style=flat-square)](https://packagist.org/packages/deved/fattura-elettronica)
[![License](https://poser.pugx.org/deved/fattura-elettronica/license)](https://packagist.org/packages/deved/fattura-elettronica)

# Fattura Elettronica verso privati e PA

## Descrizione
La libreria è stata testata generando fatture comuni.
La novità è l'aggiunta al supporto per la generazione di fatture con AltriDatiGestionali.

Potete segnalare qualsiasi necessità o problema 
[qui](https://github.com/deved-it/fattura-elettronica/issues/new).

## Installazione in progetti già esistenti

    composer require deved/fattura-elettronica
    
## Documentazione di deved.it

[deved-it.github.io/fattura-elettronica](https://deved-it.github.io/fattura-elettronica)

## Avvio e generazione fatture di prova con PHPUnit

Strumenti propedeutici già da avere effettuato con:

Composer 2.3.5
PHP Engine versione 7.4.29


## Test e generazione fattura con AltriDatiGestionali

All'interno del progetto lanciare i seguenti comandi:

    composer install

    
    .\vendor\bin\phpunit --verbose .\tests\FatturaSempliceConAltriDatiGestionaliTest.php

Verrà generata la seguente fattura con i dati preimpostati nella classe FatturaSempliceConAltriDatiGestionaliTest.php

```<?xml version="1.0" encoding="UTF-8"?>
<p:FatturaElettronica versione="FPR12" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <FatturaElettronicaHeader>
  <DatiTrasmissione>
   <IdTrasmittente>
    <IdPaese>IT</IdPaese>
    <IdCodice>12345678901</IdCodice>
   </IdTrasmittente>
   <ProgressivoInvio>12345</ProgressivoInvio>
   <FormatoTrasmissione>FPR12</FormatoTrasmissione>
   <CodiceDestinatario>XXXXXXX</CodiceDestinatario>
   <ContattiTrasmittente>
    <Telefono>+39123456789</Telefono>
    <Email>info@deved.it</Email>
   </ContattiTrasmittente>
   <PECDestinatario>pippo-pec@pluto.it</PECDestinatario>
  </DatiTrasmissione>
  <CedentePrestatore>
   <DatiAnagrafici>
    <IdFiscaleIVA>
     <IdPaese>IT</IdPaese>
     <IdCodice>12345678901</IdCodice>
    </IdFiscaleIVA>
    <CodiceFiscale>12345678901</CodiceFiscale>
    <Anagrafica>
     <Denominazione>Acme SpA</Denominazione>
    </Anagrafica>
    <RegimeFiscale>RF01</RegimeFiscale>
   </DatiAnagrafici>
   <Sede>
    <Indirizzo>Via Roma 10</Indirizzo>
    <CAP>33018</CAP>
    <Comune>Tarvisio</Comune>
    <Provincia>UD</Provincia>
    <Nazione>IT</Nazione>
   </Sede>
  </CedentePrestatore>
  <CessionarioCommittente>
   <DatiAnagrafici>
    <CodiceFiscale>XYZYZX77M04H888K</CodiceFiscale>
    <Anagrafica>
     <Denominazione>Pinco Palla</Denominazione>
    </Anagrafica>
   </DatiAnagrafici>
   <Sede>
    <Indirizzo>Via Diaz 35</Indirizzo>
    <CAP>33018</CAP>
    <Comune>Tarvisio</Comune>
    <Provincia>UD</Provincia>
    <Nazione>IT</Nazione>
   </Sede>
  </CessionarioCommittente>
 </FatturaElettronicaHeader>
 <FatturaElettronicaBody>
  <DatiGenerali>
   <DatiGeneraliDocumento>
    <TipoDocumento>TD01</TipoDocumento>
    <Divisa>EUR</Divisa>
    <Data>2018-11-22</Data>
    <Numero>2018221111</Numero>
    <ImportoTotaleDocumento>122.00</ImportoTotaleDocumento>
    <Causale>Fattura di prova</Causale>
   </DatiGeneraliDocumento>
   <DatiSAL>
    <RiferimentoFase>1</RiferimentoFase>
   </DatiSAL>
   <DatiDDT>
    <NumeroDDT>A1</NumeroDDT>
    <DataDDT>2018-11-10</DataDDT>
    <RiferimentoNumeroLinea>1</RiferimentoNumeroLinea>
    <RiferimentoNumeroLinea>2</RiferimentoNumeroLinea>
   </DatiDDT>
   <DatiDDT>
    <NumeroDDT>A2</NumeroDDT>
    <DataDDT>2018-12-09</DataDDT>
    <RiferimentoNumeroLinea>3</RiferimentoNumeroLinea>
    <RiferimentoNumeroLinea>4</RiferimentoNumeroLinea>
   </DatiDDT>
  </DatiGenerali>
  <DatiBeniServizi>
   <DettaglioLinee>
    <NumeroLinea>1</NumeroLinea>
    <CodiceArticolo>
     <CodiceTipo>EAN</CodiceTipo>
     <CodiceValore>3286340685115</CodiceValore>
    </CodiceArticolo>
    <Descrizione>Articolo1</Descrizione>
    <Quantita>2.00</Quantita>
    <UnitaMisura>pz</UnitaMisura>
    <PrezzoUnitario>25.00</PrezzoUnitario>
    <PrezzoTotale>50.00</PrezzoTotale>
    <AliquotaIVA>22.00</AliquotaIVA>
    <AltriDatiGestionali>
     <TipoDato>INTENTO</TipoDato>
    </AltriDatiGestionali>
    <AltriDatiGestionali>
     <TipoDato>DATIGEST2</TipoDato>
    </AltriDatiGestionali>
   </DettaglioLinee>
   <DatiRiepilogo>
    <AliquotaIVA>22.00</AliquotaIVA>
    <ImponibileImporto>50.00</ImponibileImporto>
    <Imposta>11.00</Imposta>
    <EsigibilitaIVA>I</EsigibilitaIVA>
   </DatiRiepilogo>
  </DatiBeniServizi>
  <DatiVeicoli>
   <Data>2022-04-16</Data>
   <TotalePercorso>100 KM</TotalePercorso>
  </DatiVeicoli>
  <DatiPagamento>
   <CondizioniPagamento>TP02</CondizioniPagamento>
   <DettaglioPagamento>
    <ModalitaPagamento>MP20</ModalitaPagamento>
    <DataScadenzaPagamento>2018-11-30</DataScadenzaPagamento>
    <ImportoPagamento>50.00</ImportoPagamento>
   </DettaglioPagamento>
  </DatiPagamento>
 </FatturaElettronicaBody>
</p:FatturaElettronica>
```
