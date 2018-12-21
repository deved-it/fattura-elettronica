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

class XmlValidator
{

    /**
     * @var array
     */
    public $errors;

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $xml
     * @param $schema
     * @return bool
     */
    public function validate($xml, $schema)
    {
        if ('' === trim($xml)) {
            throw new \InvalidArgumentException(sprintf('File %s does not contain valid XML, it is empty.', $xml));
        }

        $internalErrors = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);
        libxml_clear_errors();

        $dom = new \DOMDocument();
        $dom->validateOnParse = true;
        if (!$dom->loadXML($xml, LIBXML_NONET | (defined('LIBXML_COMPACT') ? LIBXML_COMPACT : 0))) {
            libxml_disable_entity_loader($disableEntities);
            $this->errors = $this->getXmlErrors($internalErrors);
            return false;
        }

        $dom->normalizeDocument();

        libxml_use_internal_errors($internalErrors);
        libxml_disable_entity_loader($disableEntities);

        foreach ($dom->childNodes as $child) {
            if ($child->nodeType === XML_DOCUMENT_TYPE_NODE) {
                throw new \InvalidArgumentException('Document types are not allowed.');
            }
        }

        if (null !== $schema) {
            $internalErrors = libxml_use_internal_errors(true);
            libxml_clear_errors();

            $e = null;
            if (!is_array($schema) && is_file((string) $schema)) {
                $valid = @$dom->schemaValidate($schema);
            } else {
                libxml_use_internal_errors($internalErrors);

                throw new \InvalidArgumentException('The schema argument has to be a valid path to XSD file or callable.');
            }

            if (!$valid) {
                $this->errors  = $this->getXmlErrors($internalErrors);
                return false;
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return true;
    }

    private function getXmlErrors($internalErrors)
    {
        $errors = array();
        foreach (libxml_get_errors() as $error) {
            $errors[] = $error;
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $errors;
    }

    public function isValid(){
        return !$this->getErrors();
    }
}
