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

namespace Deved\FatturaElettronica\Tests\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione;

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\DatiTrasmissione\IdTrasmittente;
use PHPUnit\Framework\TestCase;

final class IdTrasmittenteTest extends TestCase
{
    /**
     * @return IdTrasmittente
     */
    public function testCreate()
    {
        $idTrasmittente = new IdTrasmittente('IT', '123456789');
        $this->assertInstanceOf(
            IdTrasmittente::class,
            $idTrasmittente
        );
        return $idTrasmittente;
    }

    /**
     * @param self $idTrasmittente
     * @depends testCreate
     * @return \XMLWriter
     */
    public function testXmlBlock(IdTrasmittente $idTrasmittente)
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0','UTF-8');
        $writer->setIndent(4);
        $writer = $idTrasmittente->toXmlBlock($writer);
        $this->assertInstanceOf(\XMLWriter::class, $writer);
        return $writer;
    }
}
