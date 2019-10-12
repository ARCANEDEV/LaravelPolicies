<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies;

use Arcanedev\LaravelPolicies\Contracts\{
    Policy as PolicyContract,
    PolicyManager as PolicyManagerContract
};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Class     PolicyManager
 *
 * @package  Arcanedev\LaravelPolicies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PolicyManager implements PolicyManagerContract
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var  \Illuminate\Support\Collection */
    protected $policies;

    /** @var  \Illuminate\Support\Collection */
    protected $abilities;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * PolicyManager constructor.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        $this->app       = $app;
        $this->policies  = new Collection;
        $this->abilities = new Collection;
    }

    /* -----------------------------------------------------------------
     |  Getters
     | -----------------------------------------------------------------
     */

    /**
     * Get the registered policies.
     *
     * @return \Arcanedev\LaravelPolicies\Contracts\Policy[]|\Illuminate\Support\Collection
     */
    public function policies(): Collection
    {
        return $this->policies;
    }

    /**
     * Get the registered abilities.
     *
     * @return \Arcanedev\LaravelPolicies\Ability[]|\Illuminate\Support\Collection
     */
    public function abilities(): Collection
    {
        return $this->abilities;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Parse policies classes.
     *
     * @param  iterable  $classes
     *
     * @return \Illuminate\Support\Collection
     */
    public function parsePolicies(iterable $classes): Collection
    {
        return Collection::make($classes)->transform(function (string $class) {
            return $this->parsePolicy($class);
        });
    }

    /**
     * Parse the class into a policy instance.
     *
     * @param  string  $class
     *
     * @return \Arcanedev\LaravelPolicies\Contracts\Policy|mixed
     */
    public function parsePolicy(string $class): PolicyContract
    {
        return $this->app->make($class);
    }

    /**
     * Register a policy class.
     *
     * @param  string  $class
     *
     * @return \Arcanedev\LaravelPolicies\Contracts\PolicyManager
     */
    public function registerClass(string $class): PolicyManagerContract
    {
        return $this->register(
            $this->parsePolicy($class)
        );
    }

    /**
     * Register a policy instance.
     *
     * @param  \Arcanedev\LaravelPolicies\Contracts\Policy  $policy
     *
     * @return \Arcanedev\LaravelPolicies\Contracts\PolicyManager
     */
    public function register(PolicyContract $policy): PolicyManagerContract
    {
        $this->policies->put(get_class($policy), $policy);

        foreach ($this->app->call([$policy, 'abilities']) as $ability) {
            $this->registerAbility($ability);
        }

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the ability object.
     *
     * @param  \Arcanedev\LaravelPolicies\Ability  $ability
     *
     * @return $this
     */
    protected function registerAbility(Ability $ability)
    {
        $this->abilities->put($ability->key(), $ability);
        $this->gate()->define($ability->key(), $ability->method());

        return $this;
    }

    /**
     * Get the gate access instance.
     *
     * @return \Illuminate\Contracts\Auth\Access\Gate|mixed
     */
    private function gate(): Gate
    {
        return $this->app->make(Gate::class);
    }
}
