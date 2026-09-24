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
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiPagamento;
use PHPUnit\Framework\TestCase;

class DettaglioPagamentoMultiploTest extends TestCase
{
    use FatturaTestHelper;

    /**
     * Le rate di uno stesso pagamento stanno in un solo DatiPagamento
     */
    public function testPiuDettagliPagamentoInUnSoloBlocco()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiPagamento = new DatiPagamento(ModalitaPagamento::Bonifico, '2024-02-15', 61.00, null, null, 'TP01');
        $datiPagamento->addDettaglioPagamento(new DatiPagamento(ModalitaPagamento::Bonifico, '2024-03-15', 61.00));

        $fattura = $this->creaFattura($factory, null, $datiPagamento);
        $xpath = $this->xpath($fattura);

        $this->assertSame(1, $xpath->query('//DatiPagamento')->length);
        $this->assertSame('TP01', $xpath->query('//DatiPagamento/CondizioniPagamento')->item(0)->textContent);
        $dettagli = $xpath->query('//DatiPagamento/DettaglioPagamento');
        $this->assertSame(2, $dettagli->length);
        $this->assertSame('2024-03-15', $xpath->query('DataScadenzaPagamento', $dettagli->item(1))->item(0)->textContent);
        $this->assertTrue($fattura->verifica());
    }

    /**
     * addBlock() continua a creare un nuovo blocco DatiPagamento
     */
    public function testAddBlockCreaUnNuovoDatiPagamento()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiPagamento = new DatiPagamento(ModalitaPagamento::Bonifico, '2024-02-15', 22.00, null, null, 'TP03');
        $saldo = new DatiPagamento(ModalitaPagamento::Bonifico, '2024-03-15', 100.00);
        $saldo->addDettaglioPagamento(new DatiPagamento(ModalitaPagamento::Contanti, '2024-03-15', 0.50));
        $datiPagamento->addBlock($saldo);

        $fattura = $this->creaFattura($factory, null, $datiPagamento);
        $xpath = $this->xpath($fattura);

        $this->assertSame(2, $xpath->query('//DatiPagamento')->length);
        $this->assertSame(1, $xpath->query('//DatiPagamento[1]/DettaglioPagamento')->length);
        $this->assertSame(2, $xpath->query('//DatiPagamento[2]/DettaglioPagamento')->length);
        $this->assertTrue($fattura->verifica());
    }

    public function testBeneficiarioEIlPrimoElementoDelDettaglio()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiPagamento = new DatiPagamento(
            ModalitaPagamento::Bonifico,
            '2024-02-15',
            122.00,
            'IT60X0542811101000000123456',
            null,
            'TP02',
            null,
            'Acme SpA'
        );

        $fattura = $this->creaFattura($factory, null, $datiPagamento);
        $dettaglio = $this->xpath($fattura)->query('//DettaglioPagamento')->item(0);

        $this->assertSame('Beneficiario', $dettaglio->firstElementChild->nodeName);
        $this->assertSame('Acme SpA', $dettaglio->firstElementChild->textContent);
        $this->assertTrue($fattura->verifica());
    }

    /**
     * Prima Beneficiario come campo magico finiva in coda, dopo IBAN: xml non valido
     */
    public function testBeneficiarioComeCampoMagicoVaAlPostoGiusto()
    {
        $factory = $this->creaFactory();
        $this->creaCessionarioItaliano($factory);
        $datiPagamento = new DatiPagamento(ModalitaPagamento::Bonifico, '2024-02-15', 122.00, 'IT60X0542811101000000123456');
        $datiPagamento->Beneficiario = 'Acme SpA';

        $fattura = $this->creaFattura($factory, null, $datiPagamento);
        $xpath = $this->xpath($fattura);
        $dettaglio = $xpath->query('//DettaglioPagamento')->item(0);

        $this->assertSame('Beneficiario', $dettaglio->firstElementChild->nodeName);
        $this->assertSame(1, $xpath->query('//DettaglioPagamento/Beneficiario')->length);
        $this->assertTrue($fattura->verifica());
    }
}
