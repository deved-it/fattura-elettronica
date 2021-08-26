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

namespace Deved\FatturaElettronica\Codifiche;

use Deved\FatturaElettronica\Traits\CodificaTrait;

abstract class TipoCessionePrestazione
{
    use CodificaTrait;

    const Abbuono = 'AB';
    const SpesaAccessoria = 'AC';
    const Premio = 'PR';
    const Sconto = 'SC';

    protected static $codifiche = array(
        'AB' => 'Abbuono',
        'AC' => 'Spesa accessoria',
        'PR' => 'Premio',
        'SC' => 'Sconto'
    );
}
