<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies;

use Illuminate\Contracts\Support\{Arrayable, Jsonable};
use Closure;
use Illuminate\Support\Arr;
use JsonSerializable;

/**
 * Class     Ability
 *
 * @package  Arcanedev\LaravelPolicies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Ability implements Arrayable, JsonSerializable, Jsonable
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  string */
    protected $key;

    /** @var  string|\Closure */
    private $method;

    /** @var  array */
    private $metas = [];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Ability constructor.
     *
     * @param  string                $key
     * @param  string|\Closure|null  $method
     */
    public function __construct(string $key, $method = null)
    {
        $this->setKey($key);
        $this->setMethod($method ?: function () {});
    }

    /**
     * Make an ability.
     *
     * @param  string                $key
     * @param  string|\Closure|null  $method
     *
     * @return self
     */
    public static function make(string $key, $method = null): self
    {
        return new static($key, $method);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's key.
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Set the ability's key.
     *
     * @param  string  $key
     *
     * @return $this
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the ability's method.
     *
     * @return string|Closure
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Set the callback as method.
     *
     * @param  \Closure  $callback
     *
     * @return $this
     */
    public function callback(Closure $callback): self
    {
        return $this->setMethod($callback);
    }

    /**
     * Set the ability's method.
     *
     * @param  string|\Closure  $method
     *
     * @return self
     */
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the ability's meta.
     *
     * @return array
     */
    public function metas(): array
    {
        return $this->metas;
    }

    /**
     * Set the ability's meta.
     *
     * @param  array  $metas
     * @param  bool   $keepMetas
     *
     * @return self
     */
    public function setMetas(array $metas, bool $keepMetas = true): self
    {
        $this->metas = array_merge($keepMetas ? $this->metas : [], $metas);

        return $this;
    }

    /**
     * Get a meta.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function meta(string $key, $default = null)
    {
        return Arr::get($this->metas, $key, $default);
    }

    /**
     * Set a meta.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function setMeta(string $key, $value): self
    {
        Arr::set($this->metas, $key, $value);

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the ability is a callback method.
     *
     * @return bool
     */
    public function isClosure(): bool
    {
        return $this->method instanceof Closure;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'key'    => $this->key(),
            'method' => $this->isClosure() ? 'Closure' : $this->method(),
            'metas'  => $this->metas(),
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convert the object to string as JSON representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
