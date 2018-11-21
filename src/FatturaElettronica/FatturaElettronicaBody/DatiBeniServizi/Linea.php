<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 20/11/2018
 * Time: 18:01
 */

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiBeniServizi;

use Deved\FatturaElettronica\XmlSerializableInterface;

class Linea implements XmlSerializableInterface
{
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
     * @param $numeroLinea
     * @param $codiceArticolo
     * @param $descrizione
     * @param $prezzoUnitario
     * @param float $quantita
     * @param string $unitaMisura
     * @param float $aliquotaIva
     */
    public function __construct
    (
        $descrizione,
        $prezzoUnitario,
        $codiceArticolo = null,
        $quantita = 1.00,
        $unitaMisura = 'pz',
        $aliquotaIva = 22.00
    )
    {
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
            $writer->writeElement('Quantita', number_format($this->quantita, 2));
            $writer->writeElement('UnitaMisura', $this->unitaMisura);
            $writer->writeElement('PrezzoUnitario', number_format($this->prezzoUnitario, 2));
            $writer->writeElement('PrezzoTotale', $this->prezzoTotale());
            $writer->writeElement('AliquotaIva', number_format($this->aliquotaIva, 2));
        $writer->endElement();
    }

    /**
     * Calcola e restituisce il prezzo totale della linea
     *
     * @return string
     */
    protected function prezzoTotale()
    {
        return number_format($this->prezzoUnitario * $this->quantita, 2);
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
}
