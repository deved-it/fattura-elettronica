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
        '12345678901',
         'ACME Srl',
         'IT',
         '12345678901',
         RegimeFiscale::Ordinario
    );
    
    $sedeCedente = new Sede('IT', 'Via Roma 10', '33018', 'Tarvisio', 'UD');
    
    $factory = new FatturaElettronicaFactory(
        $anagraficaCedente, $sedeCedente, '+39 123 456', 'info@email.com'
    );
    
    $anagraficaCessionario = new DatiAnagrafici('XYZYZX77M04H888K', 'Pinco Palla');
    
    $sedeCessionario = new Sede('IT', 'Via Diaz 35', '33018', 'Tarvisio', 'UD');
    
    $factory->setCessionarioCommittente($anagraficaCessionario, $sedeCessionario);
    
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
    
    $linea1 = new Linea('Articolo1', 50, 1);
    $linea2 = new Linea('Articolo2', 50, 1);
    
    $dettaglioLinee = new DettaglioLinee();
    
    // aggiungere solo linee con la stessa aliquota,
    // altrimenti creare nuovo dettaglio linee
    $dettaglioLinee->addLinea($linea1);
    $dettaglioLinee->addLinea($linea2);
    
    $fattura = $factory->create(
        $datiGenerali,
        $datiPagamento,
        $dettaglioLinee,
        '001'
    );
    
    // ottenere il nome della fattura conforme per l'SDI
    $file = $fattura->getFileName();
    
    //generazione file XML con XmlFactory
    $xmlFactory = new XmlFactory();
    $xml = $xmlFactory->toXml($fattura);
    
    //print su schermo
    echo $xml;
    
    //write file
    file_put_contents($file, $xml);

