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

trait CodificaTrait
{

    /**
     * Descrizione della codifica
     *
     * @param $codice
     * @return bool|string
     */
    public static function descrizione($codice)
    {
        $descrizione = false;
        try {
            $descrizione = self::$codifiche[$codice];
        } catch (\Exception $exception) {
            //
        }
        return $descrizione;
    }
}
