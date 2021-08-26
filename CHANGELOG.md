# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.18] - 2021-08-26
### Added
- Aggiunto Arrotondamento e TipoCessionePrestazione #90 by danielebuso

## [1.1.17] - 2021-08-25
### Added
- Aggiunta impostazione decimali per linea #89 by danielebuso

## [1.1.16] - 2021-05-28
### Added
- Aggiunti supporto ai tipi DatiDocumentiCorrelati #88 by danielebuso
- Aggiunto supporto ScontoMaggiorazione linee #86 by danielebuso 
- Aggiunto Titolo e CodEORI per TerzoIntermediarioOSoggettoEmittente #85 by danielebuso
- Aggiunto codice tipo documento TD24 #83 by danielebuso

## [1.1.14] - 2021-01-27
### Added 
- Nuovi codici Natura, pull request #79 by vittominacori 
- Nuovo schema XSD, pull request #79 by vittominacori 

## [1.1.13]
### Fixed 
- Bug fix vari

## [1.1.12] - 2019-04-26
### Added 
- Aggiunto tipo codice nella linea, pull request #72 by riktar
- Aggiunto blocco DatiConvenzione, pull request #72 by riktar

## [1.1.11] - 2019-04-26
### Fixed 
- Bug fix vari

## [1.1.10] - 2019-02-05
### Added 
- Aggiunta possibilità di specificare DatiSAL e DatiVeicoli, pull request #51 by manrix

## [1.1.9]
### Fixed
- DataScadenzaPagamento facoltativa in DatiPagamento

## [1.1.8]
### Added
- possibilità di specificare allegati (grazie manrix)

## [1.1.7]
### Fixed
- bug fix vari

## [1.1.6]
### Added
- in FatturaElettronicaFactory aggiunta possibilità di settare l'IdTrasmittente

## [1.1.5]
### Added
- Possibilità di aggiungere blocchi multipli per il pagamento

## [1.1.4]
### Added
- Possibilità di aggiungere nome e cognome in dati anagrafici in alternativa a denominazione (con proprietà dinamiche)
### Fixed
- Rimosso BOM (byte order mark) da xsd/fattura_pa_1.2.1.xsd

## [1.1.3]
### Added
- Aggiunto blocco DatiGenerali/DatiContratto

### Fixed
- Diversi bug fixes
- Reso opzionale il CodiceFIscale nei DatiAnagrafici

## [1.1.2]
### Added
- Aggiunto metodo per verifica fattura con schema xsd dell'sdi
- Possibilità di aggiungere i campi DataInizioPeriodo e DataFinePeriodo
- Possibilità di aggiungere il blocco DatiGenerali => DatiDDT
- Possibilità di aggiungere IscrizioneRea

### Fixed
- Riga fattura senza quantità
- DatiPagamento opzionali

## [1.1.0]
### Added
- Righe fattura con aliquota diversa
- Possibilità di aggiungere la Natura nelle righe con importi non imponibili
- Possibilità di aggiungere la Natura nel blocco DatiRiepilogo
- DatiRiepilogo multipli
- Trait MagicFieldsTrait per aggiunta di campi dinamici in blocco o singolarmente dove la sequenza è determinante

## [1.0.7]
### Fixed
- bug fix

## [1.0.6]
### Added
- Possibilità di aggiungere nell'header i blocchi 'TerzoIntermediarioOSoggettoEmittente' e 'SoggettoEmittente' 
- IntermediarioInterface.php - interfaccia da implementare per l'aggiunta del terzo intermediario

## [1.0.5] - 2018-12-10
### Fixed
- fix Codice Fiscale nel campo idTrasmittente->idCodice utilizzando FatturaElettronicaFactory
