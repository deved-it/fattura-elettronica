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

class FatturaPR12Test extends TestCase
{
    /**
     * Test creating a FPR12 (Private) invoice and validating against FPR12 schema
     */
    public function testCreateFatturaPR12()
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

        // Create customer (Private entity)
        $anaCessionario = new DatiAnagrafici('XYZYZX77M04H888K', 'Mario Rossi');
        $sedeCessionario = new Sede('IT', 'Via Diaz 35', '20100', 'Milano', 'MI');
        
        // Set as private entity (NOT PA) - this sets formato to FPR12
        $feFactory->setCessionarioCommittente(
            $anaCessionario, 
            $sedeCessionario, 
            null,  // Default codice destinatario
            'mario.rossi@pec.it',
            false  // PA = false -> FPR12 (default)
        );

        // Create invoice data
        $datiGenerali = new DatiGenerali(
            TipoDocumento::Fattura,
            '2024-01-15',
            '2024002',
            220
        );
        $datiGenerali->Causale = "Fattura test privati (FPR12)";

        $datiPagamento = new DatiPagamento(
            ModalitaPagamento::Contanti,
            '2024-01-30',
            220
        );

        $linee = [];
        $linee[] = new Linea('Prodotto 1', 100, 'PROD001');
        $linee[] = new Linea('Prodotto 2', 120, 'PROD002');
        $dettaglioLinee = new DettaglioLinee($linee);

        // Create invoice
        $fattura = $feFactory->create(
            $datiGenerali,
            $datiPagamento,
            $dettaglioLinee,
            'PR001'
        );

        $this->assertInstanceOf(FatturaElettronica::class, $fattura);
        
        // Get XML to verify formato
        $xml = $fattura->toXml();
        
        // Verify that formato is FPR12 in XML
        $this->assertStringContainsString('versione="FPR12"', $xml);
        $this->assertStringContainsString('<FormatoTrasmissione>FPR12</FormatoTrasmissione>', $xml);
        
        // Validate against FPR12 schema
        $this->assertTrue($fattura->verifica());
        
        return $fattura;
    }

    /**
     * @depends testCreateFatturaPR12
     */
    public function testFatturaPR12XmlContent(FatturaElettronica $fattura)
    {
        $xml = $fattura->toXml();
        
        // Check that XML contains FPR12 version
        $this->assertStringContainsString('versione="FPR12"', $xml);
        
        // Verify XML is valid
        $this->assertNotEmpty($xml);
    }

    /**
     * @depends testCreateFatturaPR12
     */
    public function testFatturaPR12FileName(FatturaElettronica $fattura)
    {
        $fileName = $fattura->getFileName();
        
        // Verify filename format
        $this->assertMatchesRegularExpression('/^IT\d+_PR001\.xml$/', $fileName);
    }
}
