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

abstract class TipoDocumento
{
    use CodificaTrait;

    const Fattura = 'TD01';
    const AccontoSuFattura = 'TD02';
    const AccontoSuParcella = 'TD03';
    const NotaDiCredito = 'TD04';
    const NotaDiDebito = 'TD05';
    const Parcella = 'TD06';

    protected static $codifiche = array(
        'TD01' => 'Fattura',
        'TD02' => 'acconto/anticipo su fattura',
        'TD03' => 'acconto/anticipo su parcella',
        'TD04' => 'nota di credito',
        'TD05' => 'nota di debito',
        'TD06' => 'parcella'
    );
}
