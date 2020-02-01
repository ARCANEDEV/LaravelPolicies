<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies\Contracts;

use Illuminate\Contracts\Support\{Arrayable, Jsonable};
use Closure;
use JsonSerializable;

/**
 * Interface     Ability
 *
 * @package  Arcanedev\LaravelPolicies\Contracts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Ability extends Arrayable, JsonSerializable, Jsonable
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's key.
     *
     * @return string
     */
    public function key(): string;

    /**
     * Set the ability's key.
     *
     * @param  string  $key
     *
     * @return $this
     */
    public function setKey(string $key);

    /**
     * Get the ability's method.
     *
     * @return \Closure|string
     */
    public function method();

    /**
     * Set the callback as method.
     *
     * @param  \Closure  $callback
     *
     * @return $this
     */
    public function callback(Closure $callback);

    /**
     * Set the ability's method.
     *
     * @param  \Closure|string  $method
     *
     * @return $this
     */
    public function setMethod($method);

    /**
     * Get the ability's meta.
     *
     * @return array
     */
    public function metas(): array;

    /**
     * Set the ability's meta.
     *
     * @param  array  $metas
     * @param  bool   $keepMetas
     *
     * @return $this
     */
    public function setMetas(array $metas, bool $keepMetas = true);

    /**
     * Get a meta.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function meta(string $key, $default = null);

    /**
     * Set a meta.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return $this
     */
    public function setMeta(string $key, $value);

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the ability is a callback method.
     *
     * @return bool
     */
    public function isClosure(): bool;
}
