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

namespace Deved\FatturaElettronica;

use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody;
use Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader;

class FatturaElettronica implements XmlSerializableInterface
{
    /** @var FatturaElettronicaHeader */
    protected $fatturaElettronicaHeader;
    /** @var FatturaElettronicaBody */
    protected $fatturaElettronicaBody;
    /** @var XmlFactory */
    protected $xmlFactory;

    public function __construct(
        FatturaElettronicaHeader $fatturaElettronicaHeader,
        FatturaElettronicaBody $fatturaElettronicaBody,
        XmlFactory $xmlFactory = null
    ) {
        $this->fatturaElettronicaHeader = $fatturaElettronicaHeader;
        $this->fatturaElettronicaBody = $fatturaElettronicaBody;
        $this->xmlFactory = $xmlFactory;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElementNS('p', 'FatturaElettronica', null);
        $writer->writeAttribute('versione', 'FPR12');
        $writer->writeAttributeNS('xmlns', 'ds', null, 'http://www.w3.org/2000/09/xmldsig#');
        $writer->writeAttributeNS('xmlns', 'p', null, 'http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2');
        $writer->writeAttributeNS('xmlns', 'xsi', null, 'http://www.w3.org/2001/XMLSchema-instance');
        $this->fatturaElettronicaHeader->toXmlBlock($writer);
        $this->fatturaElettronicaBody->toXmlBlock($writer);
        $writer->endElement();
        return $writer;
    }

    public function getFileName()
    {
        $idPaese = $this->fatturaElettronicaHeader->datiTrasmissione->idTrasmittente->idPaese;
        $idCodice = $this->fatturaElettronicaHeader->datiTrasmissione->idTrasmittente->idCodice;
        $progressivoInvio = $this->fatturaElettronicaHeader->datiTrasmissione->progressivoInvio;

        return $idPaese . $idCodice . '_' . $progressivoInvio . '.xml';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toXml()
    {
        if ($this->xmlFactory) {
            return $this->xmlFactory->toXml($this);
        }
        throw new \Exception('xmlFactory non presente, utilizzare FatturaElettronicaFactory per generare le fatture');
    }
}
