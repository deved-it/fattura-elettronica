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


abstract class TipoDocumentoCorrelato
{
    const OrdineAcquisto = 'DatiOrdineAcquisto';
    const Contratto = 'DatiContratto';
    const Convenzione = 'DatiConvenzione';
    const Ricezione = 'DatiRicezione';
    const FattureCollegate = 'DatiFattureCollegate';
}
