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

namespace Deved\FatturaElettronica\Tests;

use Deved\FatturaElettronica\Codifiche\ModalitaPagamento;
use Deved\FatturaElettronica\Codifiche\RegimeFiscale;
use Deved\FatturaElettronica\Codifiche\TipoDocumento;
use Deved\FatturaElettronica\FatturaElettronica;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\Linea;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiPagamento;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use Deved\FatturaElettronica\FatturaElettronicaFactory;
use PHPUnit\Framework\TestCase;

class DatiPagamentoRiferimentoTerminiTest extends TestCase
{
    /**
     * Test that DatiPagamento with DataRiferimentoTerminiPagamento creates valid XML
     */
    public function testDatiPagamentoWithRiferimentoTermini()
    {
        // Create cedente
        $anagraficaCedente = new DatiAnagrafici(
            '12345678901',
            'Test Company',
            'IT',
            '12345678901',
            RegimeFiscale::Ordinario
        );
        $sedeCedente = new Sede('IT', 'Via Roma 1', '00100', 'Roma', 'RM');
        
        $factory = new FatturaElettronicaFactory(
            $anagraficaCedente,
            $sedeCedente,
            '+39123456789',
            'test@example.com'
        );

        // Create cessionario
        $anaCessionario = new DatiAnagrafici('RSSMRA80A01H501U', 'Mario Rossi');
        $sedeCessionario = new Sede('IT', 'Via Milano 1', '20100', 'Milano', 'MI');
        $factory->setCessionarioCommittente($anaCessionario, $sedeCessionario);

        // Create general data
        $datiGenerali = new DatiGenerali(
            TipoDocumento::Fattura,
            '2024-01-15',
            '2024/001',
            100.00
        );

        // Create payment data WITH DataRiferimentoTerminiPagamento
        $datiPagamento = new DatiPagamento(
            ModalitaPagamento::SEPA_CORE,
            '2024-02-15',
            100.00,
            'IT60X0542811101000000123456',
            'Banca Test',
            'TP02',
            '2024-01-15'  // DataRiferimentoTerminiPagamento
        );

        // Create line items
        $linee = [new Linea('Test Product', 100.00)];
        $dettaglioLinee = new DettaglioLinee($linee);

        // Create invoice
        $fattura = $factory->create(
            $datiGenerali,
            $datiPagamento,
            $dettaglioLinee,
            '00001'
        );

        $this->assertInstanceOf(FatturaElettronica::class, $fattura);

        // Get XML content
        $xml = $fattura->toXml();
        
        // Verify DataRiferimentoTerminiPagamento is present in XML
        $this->assertStringContainsString('<DataRiferimentoTerminiPagamento>2024-01-15</DataRiferimentoTerminiPagamento>', $xml);
        
        // Verify correct XML order: ModalitaPagamento -> DataRiferimentoTerminiPagamento -> DataScadenzaPagamento
        $modalitaPos = strpos($xml, '<ModalitaPagamento>');
        $riferimentoPos = strpos($xml, '<DataRiferimentoTerminiPagamento>');
        $scadenzaPos = strpos($xml, '<DataScadenzaPagamento>');
        
        $this->assertLessThan($riferimentoPos, $modalitaPos, 'ModalitaPagamento should come before DataRiferimentoTerminiPagamento');
        $this->assertLessThan($scadenzaPos, $riferimentoPos, 'DataRiferimentoTerminiPagamento should come before DataScadenzaPagamento');
        
        // Validate against XSD
        $this->assertTrue($fattura->verifica(), 'XML should validate against XSD schema');
    }

    /**
     * Test that DatiPagamento without DataRiferimentoTerminiPagamento still works
     */
    public function testDatiPagamentoWithoutRiferimentoTermini()
    {
        // Create cedente
        $anagraficaCedente = new DatiAnagrafici(
            '12345678901',
            'Test Company',
            'IT',
            '12345678901',
            RegimeFiscale::Ordinario
        );
        $sedeCedente = new Sede('IT', 'Via Roma 1', '00100', 'Roma', 'RM');
        
        $factory = new FatturaElettronicaFactory(
            $anagraficaCedente,
            $sedeCedente,
            '+39123456789',
            'test@example.com'
        );

        // Create cessionario
        $anaCessionario = new DatiAnagrafici('RSSMRA80A01H501U', 'Mario Rossi');
        $sedeCessionario = new Sede('IT', 'Via Milano 1', '20100', 'Milano', 'MI');
        $factory->setCessionarioCommittente($anaCessionario, $sedeCessionario);

        // Create general data
        $datiGenerali = new DatiGenerali(
            TipoDocumento::Fattura,
            '2024-01-15',
            '2024/002',
            100.00
        );

        // Create payment data WITHOUT DataRiferimentoTerminiPagamento (backward compatibility)
        $datiPagamento = new DatiPagamento(
            ModalitaPagamento::SEPA_CORE,
            '2024-02-15',
            100.00,
            'IT60X0542811101000000123456',
            'Banca Test'
        );

        // Create line items
        $linee = [new Linea('Test Product', 100.00)];
        $dettaglioLinee = new DettaglioLinee($linee);

        // Create invoice
        $fattura = $factory->create(
            $datiGenerali,
            $datiPagamento,
            $dettaglioLinee,
            '00002'
        );

        $this->assertInstanceOf(FatturaElettronica::class, $fattura);

        // Get XML content
        $xml = $fattura->toXml();
        
        // Verify DataRiferimentoTerminiPagamento is NOT present in XML
        $this->assertStringNotContainsString('<DataRiferimentoTerminiPagamento>', $xml);
        
        // Validate against XSD
        $this->assertTrue($fattura->verifica(), 'XML should validate against XSD schema even without DataRiferimentoTerminiPagamento');
    }
}
