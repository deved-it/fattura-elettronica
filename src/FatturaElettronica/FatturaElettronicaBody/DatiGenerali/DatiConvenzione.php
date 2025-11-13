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

namespace Deved\FatturaElettronica\FatturaElettronica\FatturaElettronicaBody\DatiGenerali;

use Deved\FatturaElettronica\Traits\MagicFieldsTrait;
use Deved\FatturaElettronica\XmlSerializableInterface;

class DatiConvenzione implements XmlSerializableInterface {
  const FE_CODE = '2.1.2';
  use MagicFieldsTrait;
  protected $codiceCommessaConvenzione;
  protected $currentIndex = 0;
  protected $riferimentoNumeroLinee = [];
  protected $idDocumento;
  protected $numItem;
  protected $codiceCUP;
  protected $codiceCIG;
  protected $data;

  /**
   * DatiContratto constructor.
   * @param string $idDocumento
   * @param string $data
   * @param string $codiceCommessaConvenzione
   * @param int[] $riferimentoNumeroLinee
   * @param string $numItem
   * @param string $codiceCUP
   * @param string $codiceCIG
   */
  public function __construct($idDocumento, $data, $codiceCommessaConvenzione, $riferimentoNumeroLinee = [], $numItem = '', $codiceCUP = null, $codiceCIG = null) {
    $this->idDocumento = $idDocumento;
    $this->riferimentoNumeroLinee = $riferimentoNumeroLinee;
    $this->data = $data;
    $this->codiceCommessaConvenzione = $codiceCommessaConvenzione;
    $this->numItem = $numItem;
    $this->codiceCUP = $codiceCUP;
    $this->codiceCIG = $codiceCIG;
  }

  /**
   * @param \XMLWriter $writer
   * @return \XMLWriter
   */
  public function toXmlBlock(\XMLWriter $writer) {
    $writer->startElement('DatiConvenzione');
    if (count($this->riferimentoNumeroLinee) > 0) {
      /** @var int $linea */
      foreach ($this->riferimentoNumeroLinee as $linea) {
        $writer->writeElement('RiferimentoNumeroLinea', $linea);
      }
    }
    $writer->writeElement('IdDocumento', $this->idDocumento);
    $writer->writeElement('Data', $this->data);
    if ($this->numItem) {
      $writer->writeElement('NumItem', $this->numItem);
    }
    $writer->writeElement('CodiceCommessaConvenzione', $this->codiceCommessaConvenzione);

    if ($this->codiceCUP) {
      $writer->writeElement('CodiceCUP', $this->codiceCUP);
    }
    if ($this->codiceCIG) {
      $writer->writeElement('CodiceCIG', $this->codiceCIG);
    }
    $writer->endElement();
    return $writer;
  }
}
