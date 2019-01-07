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
    protected $hiddenXmlFields = [];

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
        if ($this->{$field} !== false) {
            $writer->writeElement(ucfirst($field), $this->{$field});
            $this->hideXmlField($field);
        }
    }

    /**
     * Tag xmlField
     *
     * @param $field
     */
    protected function hideXmlField($field)
    {
        if (!in_array($field, $this->hiddenXmlFields)) {
            $this->hiddenXmlFields[] = $field;
        }
    }

    /**
     * @param \XMLWriter $writer
     */
    protected function writeXmlFields(\XMLWriter $writer)
    {
        foreach ($this->xmlFields as $key => $value) {
            if (!in_array($key, $this->hiddenXmlFields)) {
                $writer->writeElement(ucfirst($key), $value);
            }
        }
    }
}
