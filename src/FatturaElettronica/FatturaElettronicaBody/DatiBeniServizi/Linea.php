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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class Linea implements XmlSerializableInterface
{
    use MagicFieldsTrait;
    /** @var integer */
    protected $numeroLinea;
    /** @var string */
    protected $codiceArticolo;
    /** @var string */
    protected $descrizione;
    /** @var float */
    protected $quantita;
    /** @var string */
    protected $unitaMisura;
    /** @var float */
    protected $prezzoUnitario;
    /** @var float */
    protected $aliquotaIva;


    /**
     * Linea constructor.
     * @param $descrizione
     * @param $prezzoUnitario
     * @param null $codiceArticolo
     * @param float $quantita
     * @param string $unitaMisura
     * @param float $aliquotaIva
     */
    public function __construct(
        $descrizione,
        $prezzoUnitario,
        $codiceArticolo = null,
        $quantita = null,
        $unitaMisura = 'pz',
        $aliquotaIva = 22.00
    ) {
        $this->codiceArticolo = $codiceArticolo;
        $this->descrizione = $descrizione;
        $this->prezzoUnitario = $prezzoUnitario;
        $this->quantita = $quantita;
        $this->unitaMisura = $unitaMisura;
        $this->aliquotaIva = $aliquotaIva;
    }


    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DettaglioLinee');
        $writer->writeElement('NumeroLinea', $this->numeroLinea);
        if ($this->codiceArticolo) {
            $writer->startElement('CodiceArticolo');
                $writer->writeElement('CodiceTipo', 'FORN');
                //todo: implementare altri tipi di codice
                $writer->writeElement('CodiceValore', $this->codiceArticolo);
            $writer->endElement();
        }
        $writer->writeElement('Descrizione', $this->descrizione);
        if ($this->quantita) {
            $writer->writeElement('Quantita', fe_number_format($this->quantita, 2));
            $writer->writeElement('UnitaMisura', $this->unitaMisura);
        }
        $writer->writeElement('PrezzoUnitario', fe_number_format($this->prezzoUnitario, 2));
        $writer->writeElement('PrezzoTotale', $this->prezzoTotale());
        $writer->writeElement('AliquotaIVA', fe_number_format($this->aliquotaIva, 2));
        $this->writeXmlFields($writer);
        $writer->endElement();
        return $writer;
    }

    /**
     * Calcola e restituisce il prezzo totale della linea
     *
     * @param bool $format
     * @return string | float
     */
    public function prezzoTotale($format = true)
    {
        $quantita = $this->quantita ? $this->quantita : 1;
        if ($format) {
            return fe_number_format($this->prezzoUnitario * $quantita, 2);
        }
        return $this->prezzoUnitario * $quantita;
    }

    /**
     * Imposta il numero riga
     *
     * @param integer $n
     */
    public function setNumeroLinea($n)
    {
        $this->numeroLinea = $n;
    }

    /**
     * Restituisce Aliquota IVA
     *
     * @return float
     */
    public function getAliquotaIva()
    {
        return $this->aliquotaIva;
    }
}
