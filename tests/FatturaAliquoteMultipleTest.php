<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 17/12/2018
 * Time: 16:23
 */

namespace Deved\FatturaElettronica\Tests;

use Deved\FatturaElettronica\Codifiche\ModalitaPagamento;
use Deved\FatturaElettronica\Codifiche\Natura;
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
use Deved\FatturaElettronica\XmlValidator;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;
use PHPUnit\Framework\TestCase;

class FatturaAliquoteMultipleTest extends TestCase
{
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
     * @return DatiGenerali
     */
    public function testCreateDatiGenerali()
    {
        $datiGenerali = new DatiGenerali(
            TipoDocumento::Fattura,
            '2018-11-22',
            '2018221111',
            116
        );
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
            116
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
        $linee[] = new Linea('Articolo1', 50, 'ABC',1,'pz',22);
        $linee[]= new Linea('Articolo2', 50, 'CDE', 1,'pz',10);
        //linea con aliquota 0 e natura
        $lineaEsente = new Linea('Articolo non imponibile', 0, 'XYZ', 1, 'pz', '0');
        $lineaEsente->natura = Natura::Esenti;
        $linee[] = $lineaEsente;
        $this->assertCount(3, $linee);
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
     * @return DatiRiepilogo
     */
    public function testDatiRiepilogo()
    {
        $datiRiepilogo = new DatiRiepilogo(50,22,'I',11);
        $datiRiepilogo2 = new DatiRiepilogo(50,10,'I',6);
        $datiRiepilogo3 = new DatiRiepilogo(10,0,'I',0);
        $datiRiepilogo3->natura = Natura::Esenti;
        $datiRiepilogo3->riferimentoNormativo = "Art. x Decreto y";
        $datiRiepilogo->addDatiRiepilogo($datiRiepilogo2);
        $datiRiepilogo->addDatiRiepilogo($datiRiepilogo3);
        $this->assertInstanceOf(DatiRiepilogo::class, $datiRiepilogo);
        return $datiRiepilogo;
    }

    /**
     * @depends testSetCessionarioCommittente
     * @depends testCreateDatiGenerali
     * @depends testCreateDatiPagamento
     * @depends testCreateDettaglioLinee
     * @depends testDatiRiepilogo
     * @param FatturaElettronicaFactory $factory
     * @param DatiGenerali $datiGenerali
     * @param DatiPagamento $datiPagamento
     * @param DettaglioLinee $dettaglioLinee
     * @param DatiRiepilogo $datiRiepilogo
     * @return \Deved\FatturaElettronica\FatturaElettronica
     * @throws \Exception
     */
    public function testCreateFattura(
        FatturaElettronicaFactory $factory,
        DatiGenerali $datiGenerali,
        DatiPagamento $datiPagamento,
        DettaglioLinee $dettaglioLinee,
        DatiRiepilogo $datiRiepilogo
    ) {
        $fattura = $factory->create($datiGenerali, $datiPagamento, $dettaglioLinee, '12345', $datiRiepilogo);
        $this->assertInstanceOf(FatturaElettronica::class, $fattura);
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
        echo $fattura->toXml();
        $xmlValidator = new XmlValidator();
        $isValid = $xmlValidator->validate(
            $fattura->toXml(),
            dirname(__FILE__) . '/../xsd/fattura_pa_1.2.1.xsd'
        );
        if (!$isValid) {
            foreach ($xmlValidator->errors as $error) {
                var_dump($error);
            }
        }
        $this->assertTrue($isValid);
    }
}
