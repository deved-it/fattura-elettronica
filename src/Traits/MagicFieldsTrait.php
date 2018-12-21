<?php
/**
 * Created by PhpStorm.
 * User: salgua
 * Date: 17/12/2018
 * Time: 17:32
 */

namespace Deved\FatturaElettronica\Traits;


trait MagicFieldsTrait
{
    protected $xmlFields = [];

    public function __set($name, $value)
    {
        $this->xmlFields[$name] = $value;
    }

    public function __get($name)
    {
        if (key_exists($name, $this->xmlFields)) {
            return $this->xmlFields[$name];
        }
        return false;
    }

    /**
     * @param $field
     * @param \XMLWriter $writer
     */
    protected function writeXmlField($field, \XMLWriter $writer)
    {
        if ($this->{$field}) {
            $writer->writeElement(ucfirst($field), $this->{$field});
            $this->deleteXmlField($field);
        }
    }

    /**
     * Delete xmlField
     *
     * @param $field
     */
    protected function deleteXmlField($field)
    {
        if ($this->{$field}) {
            unset($this->xmlFields[$field]);
        }
    }

    /**
     * @param \XMLWriter $writer
     */
    protected function writeXmlFields(\XMLWriter $writer)
    {
        foreach ($this->xmlFields as $key => $value) {
            $writer->writeElement(ucfirst($key), $value);
        }
    }
}
