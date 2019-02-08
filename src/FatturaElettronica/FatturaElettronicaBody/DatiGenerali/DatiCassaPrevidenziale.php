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

class DatiCassaPrevidenziale implements XmlSerializableInterface
{
    use MagicFieldsTrait;

/*
<xs:complexType name="DatiCassaPrevidenzialeType">
    <xs:sequence>
      <xs:element name="TipoCassa"                  type="TipoCassaType"                    />
      <xs:element name="AlCassa"                    type="RateType"                         />
      <xs:element name="ImportoContributoCassa"     type="Amount2DecimalType"               />
      <xs:element name="ImponibileCassa"            type="Amount2DecimalType" minOccurs="0" />
      <xs:element name="AliquotaIVA"                type="RateType"                         />
      <xs:element name="Ritenuta"                   type="RitenutaType"       minOccurs="0" />
      <xs:element name="Natura"                     type="NaturaType"         minOccurs="0" />
      <xs:element name="RiferimentoAmministrazione" type="String20Type"       minOccurs="0" />
    </xs:sequence>
  </xs:complexType>

*/
    /** @var string */
    protected $tipo;
    /** @var float */
    protected $alCassa;
    /** @var float */
    protected $importoContributo;
    /** @var float */
    protected $imponibile;
    /** @var float */
    protected $aliquotaIVA;
    /** @var string */
    protected $ritenuta;
    /** @var string */
    protected $natura;
    /** @var string */
    protected $riferimentoAmministrazione;
/*
*/
    /**
     * DatiCassaPrevidenziale constructor.
     * @param string $numeroDdt
     * @param string $dataDdt
     * @param array $riferimentoNumeroLinee
     */
    public function __construct($tipo, $alCassa, $importo, $imponibile, $aliquotaIVA, $ritenuta, $natura, $riferimento)
    {
        $this->tipo = $tipo;
        $this->alCassa = $alCassa;
        $this->importoContributo = $importo;
        $this->imponibile = $imponibile;
        $this->aliquotaIVA = $aliquotaIVA;
        $this->ritenuta = $ritenuta;
        $this->natura = $natura;
        $this->riferimentoAmministrazione = $riferimento;
    }


    /**
     * @param \XMLWriter $writer
     * @return \XMLWriter
     */
    public function toXmlBlock(\XMLWriter $writer)
    {
        $writer->startElement('DatiCassaPrevidenziale');
                $writer->writeElement('TipoCassa', $this->tipo);
                $writer->writeElement('AlCassa', fe_number_format($this->alCassa,2));
                $writer->writeElement('ImportoContributoCassa', fe_number_format($this->importoContributo,2));
                $writer->writeElement('ImponibileCassa', fe_number_format($this->imponibile,2));
                $writer->writeElement('AliquotaIVA', fe_number_format($this->aliquotaIVA,2));
		if ($this->ritenuta) {
			$writer->writeElement('Ritenuta', $this->ritenuta);
		}
		if ($this->natura) {
			$writer->writeElement('Natura', $this->natura);
		}
		if ($this->riferimentoAmministrazione) {
			$writer->writeElement('RiferimentoAmministrazione', $this->riferimentoAmministrazione);
		}
        $writer->endElement();
        return $writer;
    }

}
