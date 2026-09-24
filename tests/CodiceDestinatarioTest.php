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

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\DatiAnagrafici;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common\Sede;
use PHPUnit\Framework\TestCase;

class CodiceDestinatarioTest extends TestCase
{
    use FatturaTestHelper;

    /**
     * Un privato italiano ha solo il codice fiscale, quindi nessun IdPaese:
     * prima riceveva XXXXXXX, il codice riservato ai soggetti esteri
     */
    public function testPrivatoItalianoSenzaPartitaIvaRiceve0000000()
    {
        $factory = $this->creaFactory();
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('RSSMRA80A01H501U', 'Mario Rossi'),
            new Sede('IT', 'Via Milano 1', '20100', 'Milano', 'MI')
        );

        $this->assertSame('0000000', $this->codiceDestinatario($factory));
    }

    public function testPrivatoEsteroSenzaPartitaIvaRiceveXXXXXXX()
    {
        $factory = $this->creaFactory();
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('', 'John Smith'),
            new Sede('GB', '10 Downing St', '00000', 'London')
        );

        $this->assertSame('XXXXXXX', $this->codiceDestinatario($factory));
    }

    public function testAziendaEsteraConPartitaIvaRiceveXXXXXXX()
    {
        $factory = $this->creaFactory();
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('', 'Muster GmbH', 'DE', '123456789'),
            new Sede('DE', 'Hauptstrasse 1', '10115', 'Berlin')
        );

        $this->assertSame('XXXXXXX', $this->codiceDestinatario($factory));
    }

    public function testCodiceDestinatarioEsplicitoVinceSempre()
    {
        $factory = $this->creaFactory();
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('', 'Muster GmbH', 'DE', '123456789'),
            new Sede('DE', 'Hauptstrasse 1', '10115', 'Berlin'),
            'ABCDEFG'
        );

        $this->assertSame('ABCDEFG', $this->codiceDestinatario($factory));
    }

    /**
     * La factory si riusa per più fatture: codice e PEC del cessionario
     * precedente non devono finire nella fattura successiva
     */
    public function testCodiceEPecNonPassanoAlCessionarioSuccessivo()
    {
        $factory = $this->creaFactory();
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('', 'Acme Srl', 'IT', '01234567890'),
            new Sede('IT', 'Via Roma 1', '00100', 'Roma', 'RM'),
            null,
            'acme@pec.it'
        );
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('RSSMRA80A01H501U', 'Mario Rossi'),
            new Sede('IT', 'Via Milano 1', '20100', 'Milano', 'MI')
        );

        $xpath = $this->xpath($this->creaFattura($factory));

        $this->assertSame('0000000', $xpath->query('//CodiceDestinatario')->item(0)->textContent);
        $this->assertSame(0, $xpath->query('//PECDestinatario')->length);
    }

    private function codiceDestinatario($factory)
    {
        $fattura = $this->creaFattura($factory);
        $this->assertTrue($fattura->verifica());

        return $this->xpath($fattura)->query('//CodiceDestinatario')->item(0)->textContent;
    }
}
