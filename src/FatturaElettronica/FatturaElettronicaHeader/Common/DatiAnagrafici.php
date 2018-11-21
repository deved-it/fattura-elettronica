<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 21/11/2018
 * Time: 15:46
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaHeader\Common;

use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiAnagrafici implements XmlSerializableInterface
{
    /** @var string */
    protected $codiceFiscale;
    /** @var string */
    protected $denominazione;
    /** @var string */
    protected $idPaese;
    /** @var string */
    protected $idCodice;
    /** @var string */
    protected $regimeFiscale;

    public function __construct
    (
        $codiceFiscale,
        $denominazione,
        $idPaese = '',
        $idCodice = '',
        $regimeFiscale = ''
    )
    {
        $this->codiceFiscale = $codiceFiscale;
        $this->denominazione = $denominazione;
        $this->idPaese = $idPaese;
        $this->idCodice = $idCodice;
        $this->regimeFiscale = $regimeFiscale;
    }

    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiAnagrafici');
            if ($this->idCodice && $this->idPaese) {
                $writer->startElement('IdFiscaleIVA');
                    $writer->writeElement('IdPaese', $this->idPaese);
                    $writer->writeElement('IdCodice', $this->idCodice);
                $writer->endElement();
            }
            $writer->writeElement('CodiceFiscale', $this->codiceFiscale);
            $writer->startElement('Anagrafica');
                $writer->writeElement('Denominazione', $this->denominazione);
            $writer->endElement();
            if ($this->regimeFiscale) {
                $writer->writeElement('RegimeFiscale', $this->regimeFiscale);
            }
        $writer->endElement();
    }
}
