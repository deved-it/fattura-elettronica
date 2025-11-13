[![Latest Version on Packagist](https://img.shields.io/packagist/v/deved/fattura-elettronica.svg?style=flat-square)](https://packagist.org/packages/deved/fattura-elettronica)
[![Build Status](https://github.com/deved-it/fattura-elettronica/actions/workflows/php.yml/badge.svg)](https://github.com/deved-it/fattura-elettronica/actions/workflows/php.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/deved/fattura-elettronica.svg?style=flat-square)](https://packagist.org/packages/deved/fattura-elettronica)
[![License](https://poser.pugx.org/deved/fattura-elettronica/license)](https://packagist.org/packages/deved/fattura-elettronica)

# Fattura Elettronica verso privati e PA

## Descrizione

Libreria PHP per la generazione di fatture elettroniche italiane in formato XML conforme alle specifiche tecniche dell'Agenzia delle Entrate. La libreria supporta la creazione di fatture sia verso privati (B2B/B2C) che verso la Pubblica Amministrazione (PA).

### Caratteristiche principali

- ✅ Generazione di fatture elettroniche conformi allo schema XSD dell'Agenzia delle Entrate
- ✅ Supporto per fatture verso privati e PA
- ✅ Validazione automatica del file XML generato
- ✅ Gestione di tutti i tipi di documento (fattura, nota di credito, nota di debito, parcella, ecc.)
- ✅ Supporto per aliquote IVA multiple
- ✅ Gestione sconti e maggiorazioni
- ✅ Supporto allegati
- ✅ Gestione documenti correlati (DDT, contratti, convenzioni, SAL)
- ✅ Supporto per intermediari e terze parti
- ✅ Gestione ritenute d'acconto e casse previdenziali
- ✅ Compatibile con PHP 8.0+

## Requisiti

- PHP ^8.0
- Estensioni PHP: `ext-xmlwriter`, `ext-libxml`, `ext-dom`, `ext-json`

## Installazione

Installa la libreria tramite Composer:

```bash
composer require deved/fattura-elettronica
```

## Utilizzo

### Esempio base - Fattura semplice

```php
<?php
use Deved\FatturaElettronica\FatturaElettronicaFactory;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiPagamento;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\Linea;
use Deved\FatturaElettronica\Codifiche\RegimeFiscale;
use Deved\FatturaElettronica\Codifiche\TipoDocumento;
use Deved\FatturaElettronica\Codifiche\ModalitaPagamento;

// 1. Dati del cedente/prestatore (chi emette la fattura)
$anagraficaCedente = new DatiAnagrafici(
    '12345678901',           // Codice fiscale
    'Acme SpA',             // Denominazione
    'IT',                   // Paese
    '12345678901',          // Partita IVA
    RegimeFiscale::Ordinario // Regime fiscale
);

$sedeCedente = new Sede(
    'IT',           // Nazione
    'Via Roma 10',  // Indirizzo
    '33018',        // CAP
    'Tarvisio',     // Comune
    'UD'            // Provincia
);

// 2. Crea la factory per la fattura
$fatturaFactory = new FatturaElettronicaFactory(
    $anagraficaCedente,
    $sedeCedente,
    '+391234567890',     // Telefono
    'info@acme.it'       // Email
);

// 3. Dati del cessionario/committente (cliente)
$anagraficaCessionario = new DatiAnagrafici(
    'RSSMRA80A01H501U',  // Codice fiscale cliente
    'Mario Rossi'         // Nome o denominazione
);

$sedeCessionario = new Sede(
    'IT',
    'Via Diaz 35',
    '33018',
    'Tarvisio',
    'UD'
);

$fatturaFactory->setCessionarioCommittente(
    $anagraficaCessionario,
    $sedeCessionario
);

// 4. Dati generali della fattura
$datiGenerali = new DatiGenerali(
    TipoDocumento::Fattura,  // Tipo documento
    '2024-01-15',           // Data fattura
    'FAT-2024-001',         // Numero fattura
    122.00                  // Importo totale documento
);

// 5. Dati di pagamento
$datiPagamento = new DatiPagamento(
    ModalitaPagamento::SEPA_CORE,  // Modalità di pagamento
    '2024-02-15',                  // Data scadenza
    122.00                         // Importo pagamento
);

// 6. Righe della fattura
$linee = [];
$linee[] = new Linea(
    'Articolo 1',  // Descrizione
    50.00,         // Prezzo unitario
    'ART001'       // Codice articolo
);
$linee[] = new Linea(
    'Articolo 2',
    50.00,
    'ART002'
);

$dettaglioLinee = new DettaglioLinee($linee);

// 7. Genera la fattura
$fattura = $fatturaFactory->create(
    $datiGenerali,
    $datiPagamento,
    $dettaglioLinee,
    '001'  // Progressivo invio
);

// 8. Ottieni il nome del file conforme per l'SDI
$nomeFile = $fattura->getFileName();

// 9. Genera l'XML
$xml = $fattura->toXml();

// 10. Valida l'XML (opzionale ma consigliato)
if ($fattura->verifica()) {
    // Salva il file
    file_put_contents($nomeFile, $xml);
    echo "Fattura generata con successo: $nomeFile\n";
} else {
    echo "Errore: la fattura non è valida\n";
}
```

### Esempio con quantità e aliquota IVA

```php
// Linea con quantità, unità di misura e aliquota IVA
$linea = new Linea(
    'Servizio di consulenza',  // Descrizione
    100.00,                     // Prezzo unitario
    'SRV001',                   // Codice articolo
    5,                          // Quantità
    'ore',                      // Unità di misura
    22.00                       // Aliquota IVA %
);

$linee = [$linea];
$dettaglioLinee = new DettaglioLinee($linee);
```

### Fattura con aliquote IVA multiple

Quando si hanno righe con aliquote IVA diverse, è necessario specificare i dati di riepilogo:

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;

// Righe con aliquote diverse
$linee = [];
$linee[] = new Linea('Prodotto al 22%', 100.00, 'P001', 1, 'pz', 22.00);
$linee[] = new Linea('Prodotto al 10%', 50.00, 'P002', 1, 'pz', 10.00);

$dettaglioLinee = new DettaglioLinee($linee);

// Riepilogo per ogni aliquota
$datiRiepilogo = new DatiRiepilogo(
    100.00,  // Imponibile
    22.00,   // Aliquota IVA
    'I'      // Esigibilità IVA (I=immediata, D=differita, S=scissione)
);
// Aggiungi altri riepiloghi per altre aliquote
$datiRiepilogo->addDatiRiepilogo(new DatiRiepilogo(50.00, 10.00, 'I'));

// Crea la fattura passando il riepilogo
$fattura = $fatturaFactory->create(
    $datiGenerali,
    $datiPagamento,
    $dettaglioLinee,
    '001',
    $datiRiepilogo  // Passa i dati di riepilogo
);
```

### Fattura con sconti e maggiorazioni

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\ScontoMaggiorazione;

// Crea uno sconto percentuale del 20%
$sconto = new ScontoMaggiorazione(
    ScontoMaggiorazione::SCONTO,  // Tipo
    20,                            // Percentuale
    null                           // Importo (null se si usa percentuale)
);

// Crea una maggiorazione di 5 euro
$maggiorazione = new ScontoMaggiorazione(
    ScontoMaggiorazione::MAGGIORAZIONE,
    null,   // Percentuale (null se si usa importo)
    5.00    // Importo
);

// Applica alla linea
$linea = new Linea('Articolo in sconto', 100.00, 'ART001', 1, 'pz', 22.00);
$linea->setScontoMaggiorazione($sconto);
$linea->setScontoMaggiorazione($maggiorazione);  // Puoi aggiungere più sconti/maggiorazioni
```

### Fattura con allegati

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\Allegato;

// Crea un allegato (il file deve essere codificato in base64)
$contenutoBase64 = base64_encode(file_get_contents('/path/to/documento.pdf'));

$allegato = new Allegato(
    'documento.pdf',      // Nome file
    $contenutoBase64,     // Contenuto in base64
    'pdf'                 // Formato allegato
);

// Aggiungi l'allegato alla fattura
$fattura = $fatturaFactory->create(
    $datiGenerali,
    $datiPagamento,
    $dettaglioLinee,
    '001',
    null,       // DatiRiepilogo
    $allegato   // Allegato
);
```

### Fattura con DDT (Documento di Trasporto)

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiDdt;

// Primo DDT
$datiDdt = new DatiDdt(
    'DDT001',         // Numero DDT
    '2024-01-10',     // Data DDT
    ['1', '2']        // Riferimenti alle righe della fattura
);

// Aggiungi altri DDT se necessario
$datiDdt->addDatiDdt(new DatiDdt('DDT002', '2024-01-12', ['3', '4']));

// Aggiungi ai dati generali
$datiGenerali->setDatiDdt($datiDdt);
```

### Fattura con contratto

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiContratto;

$datiContratto = new DatiContratto(
    'CTR2024001',    // Numero contratto
    [1, 2]           // Riferimenti alle righe
);

// Campi opzionali
$datiContratto->Data = '2024-01-01';
$datiContratto->CodiceCIG = 'CIG123456';
$datiContratto->CodiceCUP = 'CUP123456';

// Aggiungi ai dati generali
$datiGenerali->setDatiContratto($datiContratto);
```

### Fattura con convenzione

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiConvenzione;

$datiConvenzione = new DatiConvenzione(
    'CONV2024',     // Numero convenzione
    [1, 2, 3]       // Riferimenti alle righe
);
$datiConvenzione->Data = '2024-01-01';

$datiGenerali->setDatiConvenzione($datiConvenzione);
```

### Fattura con SAL (Stato Avanzamento Lavori)

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiSal;

$datiSal = new DatiSal(1);  // Numero SAL

$datiGenerali->setDatiSal($datiSal);
```

### Fattura con dati veicolo

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiVeicoli;

$datiVeicoli = new DatiVeicoli(
    '2024-01-15',   // Data prima immatricolazione
    '50000 KM'      // Totale percorso
);

// Aggiungi alla creazione della fattura
$fattura = $fatturaFactory->create(
    $datiGenerali,
    $datiPagamento,
    $dettaglioLinee,
    '001',
    null,           // DatiRiepilogo
    null,           // Allegato
    $datiVeicoli    // Dati veicolo
);
```

### Fattura con intermediario (terza parte)

```php
// Dati dell'intermediario
$intermediario = new DatiAnagrafici(
    'INTRMDR80A01H501U',
    'Studio Commercialista XYZ',
    'IT',
    '11111111111',
    RegimeFiscale::Ordinario
);

// Crea la factory con l'intermediario
$fatturaFactory = new FatturaElettronicaFactory(
    $anagraficaCedente,
    $sedeCedente,
    '+391234567890',
    'info@acme.it',
    $intermediario,    // Dati intermediario
    'TZ'              // Soggetto emittente (TZ=terzo, CC=cessionario/committente)
);
```

### Fattura con iscrizione REA

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\CedentePrestatore\IscrizioneRea;

$iscrizioneRea = new IscrizioneRea(
    'UD',        // Ufficio REA
    '123456'     // Numero REA
);

// Campi opzionali
$iscrizioneRea->CapitaleSociale = 10000.00;
$iscrizioneRea->SocioUnico = 'SU';  // SU=socio unico, SM=più soci
$iscrizioneRea->StatoLiquidazione = 'LN';  // LS=in liquidazione, LN=non in liquidazione

$fatturaFactory->setIscrizioneRea($iscrizioneRea);
```

### Fattura con ritenuta d'acconto

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiRitenuta;

$datiRitenuta = new DatiRitenuta(
    'RT01',   // Tipo ritenuta
    20.00,    // Importo ritenuta
    22.00,    // Aliquota ritenuta
    'I'       // Causale pagamento
);

$datiGenerali->setDatiRitenuta($datiRitenuta);
```

### Fattura con cassa previdenziale

```php
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali\DatiCassaPrevidenziale;
use Deved\FatturaElettronica\Codifiche\TipoCassa;

$cassaPrevidenziale = new DatiCassaPrevidenziale(
    TipoCassa::TC01,  // Tipo cassa
    4.00,             // Aliquota cassa
    20.00,            // Importo contributo cassa
    22.00,            // Aliquota IVA
    'I'               // Esigibilità IVA
);

$datiGenerali->setDatiCassaPrevidenziale($cassaPrevidenziale);
```

### Fattura con cliente estero

```php
$anagraficaCessionario = new DatiAnagrafici(
    'FOREIGN123',    // Codice identificativo estero
    'Foreign Company Ltd'
);
$anagraficaCessionario->IdPaese = 'GB';  // Paese estero

$sedeCessionario = new Sede(
    'GB',               // Nazione estera
    '10 Downing St',
    'SW1A 2AA',
    'London',
    null               // Provincia (null per estero)
);

// Il codice destinatario sarà automaticamente impostato a 'XXXXXXX'
$fatturaFactory->setCessionarioCommittente(
    $anagraficaCessionario,
    $sedeCessionario
);
```

### Fattura verso PA (Pubblica Amministrazione)

```php
$anagraficaCessionario = new DatiAnagrafici(
    '12345678901',
    'Comune di Roma'
);

$sedeCessionario = new Sede(
    'IT',
    'Piazza del Campidoglio 1',
    '00186',
    'Roma',
    'RM'
);

// Per PA: specifica codice destinatario e flag PA
$fatturaFactory->setCessionarioCommittente(
    $anagraficaCessionario,
    $sedeCessionario,
    'ABC123',  // Codice univoco ufficio (6 caratteri per PA)
    null,      // PEC
    true       // Flag PA = true
);
```

### Utilizzo con propria classe Fattura

Se hai già una tua classe per gestire le fatture, puoi usare l'interfaccia `FatturaInterface`:

```php
use Deved\FatturaElettronica\FatturaInterface;
use Deved\FatturaElettronica\FatturaAdapter;

class MiaFattura implements FatturaInterface
{
    // Implementa i metodi richiesti dall'interfaccia
    public function getCedentePrestatore() { /* ... */ }
    public function getCessionarioCommittente() { /* ... */ }
    public function getIdTrasmittente() { /* ... */ }
    // ... altri metodi
}

// Usa l'adapter per generare l'XML
$miaFattura = new MiaFattura();
$fatturaElettronica = new FatturaAdapter($miaFattura);
$xml = $fatturaElettronica->toXml();
$nomeFile = $fatturaElettronica->getFileName();
```

## Codifiche disponibili

### Tipi di documento (TipoDocumento)

```php
use Deved\FatturaElettronica\Codifiche\TipoDocumento;

TipoDocumento::Fattura              // TD01 - Fattura
TipoDocumento::AccontoSuFattura     // TD02 - Acconto/anticipo su fattura
TipoDocumento::AccontoSuParcella    // TD03 - Acconto/anticipo su parcella
TipoDocumento::NotaDiCredito        // TD04 - Nota di credito
TipoDocumento::NotaDiDebito         // TD05 - Nota di debito
TipoDocumento::Parcella             // TD06 - Parcella
TipoDocumento::FatturaDifferita     // TD24 - Fattura differita
```

### Regimi fiscali (RegimeFiscale)

```php
use Deved\FatturaElettronica\Codifiche\RegimeFiscale;

RegimeFiscale::Ordinario                          // RF01
RegimeFiscale::ContribuentiMinimi                 // RF02
RegimeFiscale::Agricoltura                        // RF04
RegimeFiscale::RegimeForfettario                  // RF19
// ... e molti altri
```

### Modalità di pagamento (ModalitaPagamento)

```php
use Deved\FatturaElettronica\Codifiche\ModalitaPagamento;

ModalitaPagamento::Contanti              // MP01
ModalitaPagamento::Assegno               // MP02
ModalitaPagamento::Bonifico              // MP05
ModalitaPagamento::CartaDiPagamento      // MP08
ModalitaPagamento::RID                   // MP09
ModalitaPagamento::RIBA                  // MP12
ModalitaPagamento::MAV                   // MP13
ModalitaPagamento::SEPA                  // MP19
ModalitaPagamento::SEPA_CORE             // MP20
ModalitaPagamento::SEPA_B2B              // MP21
// ... e altri
```

### Natura operazione (Natura)

Utilizzato per operazioni non imponibili, esenti o non soggette:

```php
use Deved\FatturaElettronica\Codifiche\Natura;

Natura::N1   // Escluse ex art. 15
Natura::N2_1 // Non soggette ad IVA
Natura::N2_2 // Non soggette - altri casi
Natura::N3_1 // Non imponibili - esportazioni
Natura::N3_2 // Non imponibili - cessioni intracomunitarie
Natura::N3_3 // Non imponibili - cessioni verso San Marino
Natura::N3_4 // Non imponibili - operazioni assimilate
Natura::N3_5 // Non imponibili - a seguito di dichiarazioni d'intento
Natura::N3_6 // Non imponibili - altre operazioni
Natura::N4   // Esenti
Natura::N5   // Regime del margine
Natura::N6_1 // Inversione contabile - cessione rottami
Natura::N6_2 // Inversione contabile - cessione oro e argento
Natura::N6_3 // Inversione contabile - subappalto settore edile
Natura::N6_4 // Inversione contabile - cessione fabbricati
Natura::N6_5 // Inversione contabile - cessione telefoni cellulari
Natura::N6_6 // Inversione contabile - cessione prodotti elettronici
Natura::N6_7 // Inversione contabile - prestazioni settore edile
Natura::N6_8 // Inversione contabile - operazioni settore energetico
Natura::N6_9 // Inversione contabile - altri casi
Natura::N7   // IVA assolta in altro stato UE
```

### Tipo cassa previdenziale (TipoCassa)

```php
use Deved\FatturaElettronica\Codifiche\TipoCassa;

TipoCassa::TC01  // Cassa nazionale previdenza e assistenza avvocati
TipoCassa::TC02  // Cassa previdenza dottori commercialisti
TipoCassa::TC03  // Cassa previdenza e assistenza geometri
TipoCassa::TC04  // Cassa nazionale previdenza e assistenza ingegneri e architetti
TipoCassa::TC05  // Cassa nazionale del notariato
TipoCassa::TC06  // Cassa nazionale previdenza e assistenza ragionieri e periti commerciali
TipoCassa::TC07  // Ente nazionale assistenza agenti e rappresentanti di commercio (ENASARCO)
TipoCassa::TC08  // Ente nazionale previdenza e assistenza consulenti del lavoro (ENPACL)
TipoCassa::TC09  // Ente nazionale previdenza e assistenza medici (ENPAM)
TipoCassa::TC10  // Ente nazionale previdenza e assistenza farmacisti (ENPAF)
TipoCassa::TC11  // Ente nazionale previdenza e assistenza veterinari (ENPAV)
TipoCassa::TC12  // Ente nazionale previdenza e assistenza impiegati dell'agricoltura (ENPAIA)
TipoCassa::TC13  // Fondo previdenza impiegati imprese di spedizione e agenzie marittime
TipoCassa::TC14  // Istituto nazionale previdenza giornalisti italiani (INPGI)
TipoCassa::TC15  // Opera nazionale assistenza orfani sanitari italiani (ONAOSI)
TipoCassa::TC16  // Cassa autonoma assistenza integrativa giornalisti italiani (CASAGIT)
TipoCassa::TC17  // Ente previdenza periti industriali e periti industriali laureati (EPPI)
TipoCassa::TC18  // Ente previdenza e assistenza pluricategoriale (EPAP)
TipoCassa::TC19  // Ente nazionale previdenza e assistenza biologi (ENPAB)
TipoCassa::TC20  // Ente nazionale previdenza e assistenza professione infermieristica (ENPAPI)
TipoCassa::TC21  // Ente nazionale previdenza e assistenza psicologi (ENPAP)
TipoCassa::TC22  // INPS
```

## Validazione XML

La libreria include un validatore XML che verifica la conformità del file generato con lo schema XSD dell'Agenzia delle Entrate:

```php
// Validazione automatica
if ($fattura->verifica()) {
    echo "Fattura valida!\n";
    file_put_contents($fattura->getFileName(), $fattura->toXml());
} else {
    echo "Fattura non valida!\n";
}

// Validazione manuale con XmlValidator
use Deved\FatturaElettronica\XmlValidator;

$validator = new XmlValidator();
$xml = $fattura->toXml();

if ($validator->validate($xml)) {
    echo "XML valido secondo lo schema XSD\n";
} else {
    echo "XML non valido:\n";
    print_r($validator->getErrors());
}
```

## Campi dinamici

Alcune classi supportano campi dinamici che possono essere aggiunti dopo la creazione dell'oggetto:

```php
// Esempio con DatiAnagrafici
$datiAnagrafici = new DatiAnagrafici('RSSMRA80A01H501U');
$datiAnagrafici->Nome = 'Mario';
$datiAnagrafici->Cognome = 'Rossi';

// Esempio con DatiGenerali
$datiGenerali = new DatiGenerali(/* ... */);
$datiGenerali->Causale = "Fattura per prestazione professionale";
$datiGenerali->Art73 = 'SI';  // Operazioni straordinarie (fusioni, scissioni, conferimenti)

// Esempio con Linea
$linea = new Linea(/* ... */);
$linea->DataInizioPeriodo = '2024-01-01';
$linea->DataFinePeriodo = '2024-01-31';
$linea->Ritenuta = 'SI';
```

## Nome file conforme

La libreria genera automaticamente un nome file conforme alle specifiche SDI:

```php
$nomeFile = $fattura->getFileName();
// Esempio: IT12345678901_00001.xml
// Formato: [IdentificativoTrasmittente]_[ProgressivoInvio].xml
```

## Risoluzione problemi comuni

### Errore: "Dati cessionario non presenti"

Assicurati di aver chiamato `setCessionarioCommittente()` prima di creare la fattura:

```php
$fatturaFactory->setCessionarioCommittente($anagraficaCessionario, $sedeCessionario);
```

### Fattura non passa la validazione

Verifica che:
- Tutti i campi obbligatori siano compilati
- Gli importi siano coerenti (somma righe = totale fattura)
- Le aliquote IVA siano corrette
- I codici fiscali e partite IVA siano validi
- Le date siano nel formato corretto (YYYY-MM-DD)

### Imponibili non quadrano

Quando usi aliquote IVA multiple, assicurati di creare correttamente i `DatiRiepilogo` per ogni aliquota.

## Supporto e contributi

Per segnalare bug, richiedere funzionalità o contribuire al progetto:

- **Issues**: [https://github.com/deved-it/fattura-elettronica/issues](https://github.com/deved-it/fattura-elettronica/issues)
- **Pull Requests**: [https://github.com/deved-it/fattura-elettronica/pulls](https://github.com/deved-it/fattura-elettronica/pulls)

## Licenza

Questa libreria è rilasciata sotto licenza MIT. Vedi il file [LICENSE](../LICENSE) per maggiori dettagli.

## Credits

- Salvatore Guarino (autore originale)
- Tutti i [contributori](https://github.com/deved-it/fattura-elettronica/contributors)

## Changelog

Vedi [CHANGELOG.md](../CHANGELOG.md) per la lista completa delle modifiche.

