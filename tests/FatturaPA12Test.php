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

class FatturaPA12Test extends TestCase
{
    /**
     * Test creating a FPA12 (Public Administration) invoice and validating against FPA12 schema
     */
    public function testCreateFatturaPA12()
    {
        // Create supplier (cedente)
        $anagraficaCedente = new DatiAnagrafici(
            '12345678901',
            'Acme SpA',
            'IT',
            '12345678901',
            RegimeFiscale::Ordinario
        );
        $sedeCedente = new Sede('IT', 'Via Roma 10', '33018', 'Tarvisio', 'UD');

        // Create factory
        $feFactory = new FatturaElettronicaFactory(
            $anagraficaCedente,
            $sedeCedente,
            '+39123456789',
            'info@deved.it'
        );

        // Create customer (PA - Public Administration)
        $anaCessionario = new DatiAnagrafici('12345678901', 'Comune di Test');
        $sedeCessionario = new Sede('IT', 'Via della PA 1', '00100', 'Roma', 'RM');
        
        // Set as PA (Public Administration) - this sets formato to FPA12
        $feFactory->setCessionarioCommittente(
            $anaCessionario, 
            $sedeCessionario, 
            'ABCDEF',  // Codice destinatario for PA
            null,
            true  // PA = true -> FPA12
        );

        // Create invoice data
        $datiGenerali = new DatiGenerali(
            TipoDocumento::Fattura,
            '2024-01-15',
            '2024001',
            100
        );
        $datiGenerali->Causale = "Fattura test PA (FPA12)";

        $datiPagamento = new DatiPagamento(
            ModalitaPagamento::Bonifico,
            '2024-02-15',
            100
        );

        $linee = [];
        $linee[] = new Linea('Servizio test PA', 100);
        $dettaglioLinee = new DettaglioLinee($linee);

        // Create invoice
        $fattura = $feFactory->create(
            $datiGenerali,
            $datiPagamento,
            $dettaglioLinee,
            'PA001'
        );

        $this->assertInstanceOf(FatturaElettronica::class, $fattura);
        
        // Get XML to verify formato
        $xml = $fattura->toXml();
        
        // Verify that formato is FPA12 in XML
        $this->assertStringContainsString('versione="FPA12"', $xml);
        $this->assertStringContainsString('<FormatoTrasmissione>FPA12</FormatoTrasmissione>', $xml);
        
        // Validate against FPA12 schema
        $this->assertTrue($fattura->verifica());
        
        return $fattura;
    }

    /**
     * @depends testCreateFatturaPA12
     */
    public function testFatturaPA12XmlContent(FatturaElettronica $fattura)
    {
        $xml = $fattura->toXml();
        
        // Check that XML contains FPA12 version
        $this->assertStringContainsString('versione="FPA12"', $xml);
        
        // Verify XML is valid
        $this->assertNotEmpty($xml);
    }

    /**
     * @depends testCreateFatturaPA12
     */
    public function testFatturaPA12FileName(FatturaElettronica $fattura)
    {
        $fileName = $fattura->getFileName();
        
        // Verify filename format
        $this->assertMatchesRegularExpression('/^IT\d+_PA001\.xml$/', $fileName);
    }
}
