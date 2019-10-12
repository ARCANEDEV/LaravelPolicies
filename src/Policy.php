<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies;

use Arcanedev\LaravelPolicies\Contracts\Policy as PolicyContract;
use Illuminate\Support\Str;

/**
 * Class     Policy
 *
 * @package  Arcanedev\LaravelPolicies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Policy implements PolicyContract
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Default metas for the abilities.
     *
     * @var array
     */
    protected $metas = [];

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's prefix.
     *
     * @return string
     */
    protected static function prefix(): string
    {
        return '';
    }

    /**
     * Set the default metas for the abilities.
     *
     * @return array
     */
    protected function getMetas(): array
    {
        return $this->metas;
    }

    /**
     * Set the default metas for the abilities.
     *
     * @param  array  $metas
     *
     * @return $this
     */
    protected function setMetas(array $metas)
    {
        $this->metas = $metas;

        return $this;
    }

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
    public static function ability($keys)
    {
        if (is_string($keys))
            return static::prefixedKey($keys);

        return array_map(function (string $key) {
            return static::prefixedKey($key);
        }, (array) $keys);
    }

    /**
     * Make a new ability.
     *
     * @param  string       $key
     * @param  string|null  $method
     *
     * @return \Arcanedev\LaravelPolicies\Ability
     */
    protected function makeAbility(string $key, $method = null): Ability
    {
        return Ability::make(
            static::prefixedKey($key),
            static::prepareMethod($method ?: $key)
        )->setMetas($this->getMetas());
    }

    /**
     * Get a prefixed key.
     *
     * @param  string  $key
     *
     * @return string
     */
    protected static function prefixedKey(string $key): string
    {
        return empty($prefix = static::prefix())
            ? $key
            : trim($prefix.$key);
    }

    /**
     * Prepare the method name.
     *
     * @param  string  $method
     *
     * @return string|null
     */
    protected static function prepareMethod(string $method): ?string
    {
        // Dedicated Class
        if (class_exists($method))
            return $method;

        // Dedicated Method
        $method = Str::camel($method);

        if (method_exists(static::class, $method))
            return static::class.'@'.$method;

        return null;
    }
}
