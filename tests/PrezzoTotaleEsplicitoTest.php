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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\Linea;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi\ScontoMaggiorazione;
use PHPUnit\Framework\TestCase;

class PrezzoTotaleEsplicitoTest extends TestCase
{
    use FatturaTestHelper;

    public function testSenzaPrezzoTotaleEsplicitoVieneCalcolato()
    {
        $linea = new Linea('3 notti', 33.33, null, 3, null, 10.00);

        $this->assertSame('99.99', $linea->prezzoTotale());
    }

    public function testPrezzoTotaleEsplicitoSostituisceQuelloCalcolato()
    {
        $linea = new Linea('3 notti', 33.33, null, 3, null, 10.00);
        $linea->setPrezzoTotale(100.00);

        $this->assertSame('100.00', $linea->prezzoTotale());
        $this->assertSame('100.00', $linea->prezzoTotale(false));
    }

    public function testPrezzoTotaleEsplicitoNonApplicaGliSconti()
    {
        $linea = new Linea('Articolo', 100.00);
        $linea->setScontoMaggiorazione(new ScontoMaggiorazione(ScontoMaggiorazione::SCONTO, 10, null));
        $linea->setPrezzoTotale(95.00);

        $this->assertSame('95.00', $linea->prezzoTotale());
    }

    public function testNullRipristinaIlCalcolo()
    {
        $linea = new Linea('3 notti', 33.33, null, 3, null, 10.00);
        $linea->setPrezzoTotale(100.00);
        $linea->setPrezzoTotale(null);

        $this->assertSame('99.99', $linea->prezzoTotale());
    }

    public function testRiepilogoCalcolatoUsaIlPrezzoTotaleEsplicito()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $linea = new Linea('3 notti', 33.33, null, 3, null, 10.00);
        $linea->setPrezzoTotale(100.00);

        $fattura = $this->creaFattura($factory, $this->creaDatiGenerali(110.00), null, [$linea]);
        $xpath = $this->xpath($fattura);

        $this->assertSame('100.00', $xpath->query('//DettaglioLinee/PrezzoTotale')->item(0)->textContent);
        $this->assertSame('100.00', $xpath->query('//DatiRiepilogo/ImponibileImporto')->item(0)->textContent);
        $this->assertTrue($fattura->verifica());
    }
}
