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

/**
 * Costruisce fatture minime valide, in cui ogni test cambia solo la parte che verifica
 */
trait FatturaTestHelper
{
    protected function creaFactory()
    {
        $anagraficaCedente = new DatiAnagrafici(
            '12345678901',
            'Acme SpA',
            'IT',
            '12345678901',
            RegimeFiscale::Ordinario
        );
        $sedeCedente = new Sede('IT', 'Via Roma 10', '33018', 'Tarvisio', 'UD');

        return new FatturaElettronicaFactory($anagraficaCedente, $sedeCedente, '+39123456789', 'info@deved.it');
    }

    protected function creaDatiGenerali($importo = 122.00)
    {
        return new DatiGenerali(TipoDocumento::Fattura, '2024-01-15', 'FAT-2024-001', $importo);
    }

    /**
     * @param FatturaElettronicaFactory $factory
     * @param DatiGenerali|null $datiGenerali
     * @param DatiPagamento|null $datiPagamento
     * @param Linea[]|null $linee
     * @return FatturaElettronica
     */
    protected function creaFattura(
        FatturaElettronicaFactory $factory,
        $datiGenerali = null,
        $datiPagamento = null,
        $linee = null
    ) {
        return $factory->create(
            $datiGenerali ?: $this->creaDatiGenerali(),
            $datiPagamento ?: new DatiPagamento(ModalitaPagamento::Bonifico, '2024-02-15', 122.00),
            new DettaglioLinee($linee ?: [new Linea('Articolo', 100.00)]),
            '00001'
        );
    }

    protected function creaCessionarioItaliano(FatturaElettronicaFactory $factory)
    {
        $factory->setCessionarioCommittente(
            new DatiAnagrafici('XYZYZX77M04H888K', 'Pinco Palla'),
            new Sede('IT', 'Via Diaz 35', '33018', 'Tarvisio', 'UD'),
            'ABCDEFG'
        );
    }

    /**
     * @param FatturaElettronica $fattura
     * @return \DOMXPath
     */
    protected function xpath(FatturaElettronica $fattura)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($fattura->toXml());

        return new \DOMXPath($dom);
    }
}
