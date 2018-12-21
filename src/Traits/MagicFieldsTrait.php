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
