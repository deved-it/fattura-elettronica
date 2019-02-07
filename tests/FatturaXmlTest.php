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
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiVeicoli;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use Deved\FatturaElettronica\FatturaElettronicaFactory;
use Deved\FatturaElettronica\XmlValidator;
use PHPUnit\Framework\TestCase;

class FatturaXmlTest extends TestCase
{
    protected $xmlSample;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->xmlSample = file_get_contents(__DIR__ . '/samples/fattura.xml');
    }

    /**
     * @return DatiAnagrafici
     */
    public function testCreateAnagraficaCedente()
    {
        $anagraficaCedente = new DatiAnagrafici(
            '12345678901',
            'Acme SpA',
            'IT',
            '12345678901',
            RegimeFiscale::Ordinario
        );
        $this->assertInstanceOf(DatiAnagrafici::class, $anagraficaCedente);
        return $anagraficaCedente;
    }

    /**
     * @return Sede
     */
    public function testCreateSedeCedente()
    {
        $sedeCedente = new Sede('IT', 'Via Roma 10', '33018', 'Tarvisio', 'UD');
        $this->assertInstanceOf(Sede::class, $sedeCedente);
        return $sedeCedente;
    }

    /**
     * @depends testCreateAnagraficaCedente
     * @depends testCreateSedeCedente
     * @param DatiAnagrafici $datiAnagrafici
     * @param Sede $sede
     * @return FatturaElettronicaFactory
     */
    public function testCreateFatturaElettronicaFactory(DatiAnagrafici $datiAnagrafici, Sede $sede)
    {
        $feFactory = new FatturaElettronicaFactory(
            $datiAnagrafici,
            $sede,
            '+39123456789',
            'info@deved.it'
        );
        $this->assertInstanceOf(FatturaElettronicaFactory::class, $feFactory);
        return $feFactory;
    }

    /**
     * @return DatiAnagrafici
     */
    public function testCreateAnagraficaCessionario()
    {
        $anaCessionario = new DatiAnagrafici('XYZYZX77M04H888K', 'Pinco Palla');
        $this->assertInstanceOf(DatiAnagrafici::class, $anaCessionario);
        return $anaCessionario;
    }

    /**
     * @return Sede
     */
    public function testCreateSedeCessionario()
    {
        $sedeCessionario = new Sede('IT', 'Via Diaz 35', '33018', 'Tarvisio', 'UD');
        $this->assertInstanceOf(Sede::class, $sedeCessionario);
        return$sedeCessionario;
    }

    /**
     * @depends testCreateFatturaElettronicaFactory
     * @depends testCreateAnagraficaCessionario
     * @depends testCreateSedeCessionario
     * @param FatturaElettronicaFactory $factory
     * @param DatiAnagrafici $datiAnagrafici
     * @param Sede $sede
     * @return FatturaElettronicaFactory
     */
    public function testSetCessionarioCommittente(
        FatturaElettronicaFactory $factory,
        DatiAnagrafici $datiAnagrafici,
        Sede $sede
    ) {
        $factory->setCessionarioCommittente($datiAnagrafici, $sede);
        $this->assertInstanceOf(FatturaElettronicaFactory::class, $factory);
        return $factory;
    }

    /**
     * @return DatiGenerali\DatiDdt
     */
    public function testDatiDdt()
    {
        $datiDdt = new DatiGenerali\DatiDdt('A1', '2018-11-10', ['1', '2']);
        $datiDdt->addDatiDdt(new DatiGenerali\DatiDdt('A2', '2018-12-09', ['3', '4']));
        $this->assertInstanceOf(DatiGenerali\DatiDdt::class, $datiDdt);
        return $datiDdt;
    }

    /**
     * @return DatiGenerali\DatiSal
     */
    public function testDatiSal()
    {
        $datiSal = new DatiGenerali\DatiSal(1);
        $datiSal->addDatiSal(new DatiGenerali\DatiSal(2));
        $this->assertInstanceOf(DatiGenerali\DatiSal::class, $datiSal);
        return $datiSal;
    }

    /**
     * @depends testDatiDdt
     * @depends testDatiSal
     * @param DatiGenerali\DatiDdt $datiDdt
     * @return DatiGenerali
     */
    public function testCreateDatiGenerali(DatiGenerali\DatiDdt $datiDdt, DatiGenerali\DatiSal $datiSal)
    {
        $datiGenerali = new DatiGenerali(
            TipoDocumento::Fattura,
            '2018-11-22',
            '2018221111',
            122
        );
        $datiGenerali->setDatiDdt($datiDdt);
        $datiGenerali->setDatiSal($datiSal);
        $datiGenerali->Causale = "Fattura di prova";
        $this->assertInstanceOf(DatiGenerali::class, $datiGenerali);
        return $datiGenerali;
    }

    /**
     * @return DatiPagamento
     */
    public function testCreateDatiPagamento()
    {
        $datiPagamento = new DatiPagamento(
            ModalitaPagamento::SEPA_CORE,
            '2018-11-30',
            122
        );
        $this->assertInstanceOf(DatiPagamento::class, $datiPagamento);
        return $datiPagamento;
    }

    /**
     * @return array
     */
    public function testCreateLinee()
    {
        $linee = [];
        $linee[] = new Linea('Articolo1', 50, 'ABC');
        $linee[]= new Linea('Articolo2', 25, 'CDE', 2);
        $this->assertCount(2, $linee);
        return $linee;
    }

    /**
     * @param array $linee
     * @depends testCreateLinee
     * @return DettaglioLinee
     */
    public function testCreateDettaglioLinee($linee)
    {
        $dettaglioLinee = new DettaglioLinee($linee);
        $this->assertInstanceOf(DettaglioLinee::class, $dettaglioLinee);
        return $dettaglioLinee;
    }

    /**
     * @return DatiVeicoli
     */
    public function testCreateDatiVeicoli()
    {
        $datiVeicoli = new DatiVeicoli(date('Y-m-d'), '100 KM');
        $this->assertInstanceOf(DatiVeicoli::class, $datiVeicoli);
        return $datiVeicoli;
    }

    /**
     * @depends testSetCessionarioCommittente
     * @depends testCreateDatiGenerali
     * @depends testCreateDatiPagamento
     * @depends testCreateDettaglioLinee
     * @depends testCreateDatiVeicoli
     * @param FatturaElettronicaFactory $factory
     * @param DatiGenerali $datiGenerali
     * @param DatiPagamento $datiPagamento
     * @param DettaglioLinee $dettaglioLinee
     * @param DatiVeicoli $datiVeicoli
     * @return \Deved\FatturaElettronica\FatturaElettronica
     * @throws \Exception
     */
    public function testCreateFattura(
        FatturaElettronicaFactory $factory,
        DatiGenerali $datiGenerali,
        DatiPagamento $datiPagamento,
        DettaglioLinee $dettaglioLinee,
        DatiVeicoli $datiVeicoli
    ) {
        $fattura = $factory->create(
            $datiGenerali,
            $datiPagamento,
            $dettaglioLinee,
            '12345',
            null,
            null,
            $datiVeicoli
        );
        $this->assertInstanceOf(FatturaElettronica::class, $fattura);
        //file_put_contents(__DIR__ . '/samples/fattura.xml', $fattura->toXml());
        return $fattura;
    }

    /**
     * @depends testCreateFattura
     * @param FatturaElettronica $fattura
     */
    public function testGetNomeFattura(FatturaElettronica $fattura)
    {
        $name = $fattura->getFileName();
        $this->assertTrue(strlen($name) > 5);
    }

    /**
     * @depends testCreateFattura
     * @param FatturaElettronica $fattura
     * @throws \Exception
     */
    public function testXmlSchemaFattura(FatturaElettronica $fattura)
    {
        $this->assertTrue($fattura->verifica());
    }

    /**
     * @depends testCreateFattura
     * @param FatturaElettronica $fattura
     * @throws \Exception
     */
    public function testXmlFattura(FatturaElettronica $fattura)
    {
        $this->assertEquals($fattura->toXml(), $this->xmlSample);
    }
}