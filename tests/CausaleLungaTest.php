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

use PHPUnit\Framework\TestCase;

/**
 * Causale è String200LatinType con maxOccurs="unbounded":
 * un testo oltre i 200 caratteri va diviso in più elementi
 */
class CausaleLungaTest extends TestCase
{
    use FatturaTestHelper;

    public function testCausaleOltre200CaratteriVieneDivisa()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiGenerali = $this->creaDatiGenerali();
        $causale = str_repeat('Prenotazione ', 40); // 520 caratteri
        $datiGenerali->setCausale($causale);

        $fattura = $this->creaFattura($factory, $datiGenerali);
        $parti = $this->xpath($fattura)->query('//DatiGeneraliDocumento/Causale');

        $this->assertSame(3, $parti->length);
        $this->assertSame(200, strlen($parti->item(0)->textContent));
        $this->assertSame(200, strlen($parti->item(1)->textContent));
        $this->assertSame($causale, $parti->item(0)->textContent . $parti->item(1)->textContent . $parti->item(2)->textContent);
        $this->assertTrue($fattura->verifica());
    }

    public function testCausaleBreveRestaUnSoloElemento()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiGenerali = $this->creaDatiGenerali();
        $datiGenerali->setCausale('Fattura di prova');

        $fattura = $this->creaFattura($factory, $datiGenerali);
        $parti = $this->xpath($fattura)->query('//DatiGeneraliDocumento/Causale');

        $this->assertSame(1, $parti->length);
        $this->assertSame('Fattura di prova', $parti->item(0)->textContent);
        $this->assertTrue($fattura->verifica());
    }

    public function testCausaleComeCampoMagicoVieneDivisa()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiGenerali = $this->creaDatiGenerali();
        $datiGenerali->Causale = str_repeat('a', 250);

        $fattura = $this->creaFattura($factory, $datiGenerali);
        $parti = $this->xpath($fattura)->query('//DatiGeneraliDocumento/Causale');

        $this->assertSame(2, $parti->length);
        $this->assertTrue($fattura->verifica());
    }

    /**
     * Il pattern dell'XSD conta i caratteri: una lettera accentata vale uno, non due byte
     */
    public function testCausaleDivisaPerCaratteriNonPerByte()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiGenerali = $this->creaDatiGenerali();
        $datiGenerali->setCausale(str_repeat('è', 200));

        $fattura = $this->creaFattura($factory, $datiGenerali);
        $parti = $this->xpath($fattura)->query('//DatiGeneraliDocumento/Causale');

        $this->assertSame(1, $parti->length);
        $this->assertTrue($fattura->verifica());
    }
}
