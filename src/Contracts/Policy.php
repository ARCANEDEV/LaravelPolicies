<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies\Contracts;

/**
 * Interface  Policy
 *
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
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
