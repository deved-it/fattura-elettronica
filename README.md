# Fattura Elettronica verso privati e PA

## Descrizione
La libreria è stata testata generando solo fatture semplici. 
I casi particolari non sono stati ancora trattati. 
Potete segnalare qualsiasi necessità o problema 
[qui](https://github.com/deved-it/fattura-elettronica/issues/new).

## installazione

    composer require deved/fattura-elettronica

## Esempio

    $anagraficaCedente = new DatiAnagrafici(
                '123456789',
                'Acme SpA',
                'IT',
                '12345678901',
                RegimeFiscale::Ordinario);
    $sedeCedente = new Sede('IT', 'Via Roma 10', '33018', 'Tarvisio', 'UD');

    $fatturaElettronicaFactory = new FatturaElettronicaFactory(
        $anagraficaCedente, $sedeCedente, '+391234567', 'info@email.it');

    $anagraficaCessionario = new DatiAnagrafici('XYZYZX77M04H888K', 'Pinco Palla');

    $sedeCessionario = new Sede('IT', 'Via Diaz 35', '33018', 'Tarvisio', 'UD');

    $fatturaElettronicaFactory->setCessionarioCommittente($anagraficaCessionario, $sedeCessionario);

    $datiGenerali = new DatiGenerali(
        TipoDocumento::Fattura,
        '2018-11-22',
        '2018221111',
        122
    );

    $datiPagamento = new DatiPagamento(
        ModalitaPagamento::SEPA_CORE,
        '2018-11-30',
        122
    );
    $linee = [];
    // linee fattura
    // aggiungere solo linee con la stessa aliquota. Per adesso non gestisce blocchi DatiBeniServizi multipli

    $linee[] = new Linea('Articolo1', 50, 'ABC');
    $linee[]= new Linea('Articolo2', 50, 'CDE');

    $dettaglioLinee = new DettaglioLinee($linee);

    $fattura = $fatturaElettronicaFactory->create(
        $datiGenerali,
        $datiPagamento,
        $dettaglioLinee,
        '001'
    );

    // ottenere il nome della fattura conforme per l'SDI
    $file = $fattura->getFileName();
    
    //generazione file XML 
    $xml = $fattura->toXml();
    
    //print su schermo
    echo $xml;
    
    //scrivi file
    file_put_contents($file, $xml);

