<?php

namespace Deved\FatturaElettronica;

class Factory
{
    protected $className = Invoice::class;

    protected $settings = [];

    public function __construct(array $settings = [], string $className = null)
    {
        if ($className) {
            $this->className = $className;
        }
        $this->settings = $settings;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function setClassName(string $className)
    {
        $this->className = $className;
        return $this;
    }

    public function className(string $className = null)
    {
        return $className === null ? $this->getClassName() : $this->setClassName($className);
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    public function settings(array $settings = null)
    {
        return $settings === null ? $this->getSettings() : $this->setSettings($settings);
    }

    public function mergeSettings(array $settings)
    {
        $this->settings = array_merge($this->settings, $settings);
        return $this;
    }

    public function __call($name, $arguments)
    {
        $result = $this->className::$name(...$arguments);
        return $result instanceof InvoiceInterface ? $result->settings($this->settings) : $result;
    }
}
