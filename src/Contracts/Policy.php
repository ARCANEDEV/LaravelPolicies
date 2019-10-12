<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies\Contracts;

/**
 * Class     Policy
 *
 * @package  Arcanedev\LaravelPolicies\Contracts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @method  \Arcanedev\LaravelPolicies\Ability[]|iterable  abilities()
 */
interface Policy
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's key.
     *
     * @param  array|string  $keys
     *
     * @return array|string
     */
    public static function ability($keys);
}
